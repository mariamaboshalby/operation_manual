<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Lesson;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class LessonCompletionController extends Controller
{
    /**
     * POST /lessons/{lesson}/complete
     *
     * Mark the authenticated user's lesson as completed.
     * Idempotent — repeated calls update the timestamp but never duplicate records.
     * After each completion, checks whether the full tutorial is now complete
     * and generates a certificate when eligible.
     */
    public function store(Request $request, Lesson $lesson)
    {
        $user     = $request->user();
        $tutorial = $lesson->tutorial;

        // ── Authorization ────────────────────────────────────────
        // Reuses the same access rules as viewing the tutorial:
        //   admin   → always allowed
        //   user    → always allowed
        //   student → only if the tutorial is assigned to them
        Gate::authorize('complete', $tutorial);

        // ── Idempotent completion ────────────────────────────────
        DB::transaction(function () use ($user, $lesson, $tutorial) {

            // updateOrCreate prevents duplicate rows (unique user_id+lesson_id)
            $user->completedLessons()->syncWithoutDetaching([
                $lesson->id => ['completed_at' => now()],
            ]);

            // ── Certificate generation ────────────────────────────
            $this->tryIssueCertificate($user, $tutorial);
        });

        if ($request->wantsJson()) {
            $progress = $tutorial->progressFor($user);
            return response()->json([
                'success'  => true,
                'progress' => $progress,
            ]);
        }

        return back()->with('lesson_completed', $lesson->id);
    }

    /**
     * Issue a certificate if all conditions are met.
     * Safe to call multiple times — never creates duplicates.
     */
    protected function tryIssueCertificate($user, Tutorial $tutorial): void
    {
        // Condition 1: certificate feature must be enabled for this tutorial
        if (! $tutorial->certificate_enabled) {
            return;
        }

        // Condition 2: all lessons must be completed
        $progress = $tutorial->progressFor($user);
        if (! $progress['is_complete']) {
            return;
        }

        // Condition 3: do not issue a second certificate
        $exists = Certificate::where('user_id', $user->id)
            ->where('tutorial_id', $tutorial->id)
            ->exists();

        if ($exists) {
            return;
        }

        // Generate a cryptographically unique, publicly safe certificate number
        $year   = now()->year;
        $unique = strtoupper(Str::random(8));
        $certNumber = "CERT-{$year}-{$unique}";

        // Guarantee uniqueness in the unlikely event of a collision
        while (Certificate::where('certificate_number', $certNumber)->exists()) {
            $unique     = strtoupper(Str::random(8));
            $certNumber = "CERT-{$year}-{$unique}";
        }

        Certificate::create([
            'user_id'            => $user->id,
            'tutorial_id'        => $tutorial->id,
            'certificate_number' => $certNumber,
            'issued_at'          => now(),
            'completed_at'       => now(),
            'status'             => 'valid',
        ]);
    }
}
