<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class LessonController extends Controller
{
    // ── Admin: lessons management page ───────────────────────────

    public function index(Tutorial $tutorial)
    {
        return view('admin.lessons', [
            'tutorial' => $tutorial->load('lessons'),
        ]);
    }

    // ── Admin: create lesson ─────────────────────────────────────

    public function store(Request $request, Tutorial $tutorial)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'video_url'        => ['nullable', 'string', 'max:500', function ($attr, $value, $fail) {
                if ($value && !isValidYoutubeUrl($value)) {
                    $fail('رابط الفيديو يجب أن يكون رابط YouTube صالح (youtube.com أو youtu.be).');
                }
            }],
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $data['order'] = $tutorial->lessons()->max('order') + 1;
        $tutorial->lessons()->create($data);

        $tutorial->update(['steps' => $tutorial->lessons()->count()]);

        return back()->with('success', 'تم إضافة الدرس');
    }

    // ── Admin: update lesson ─────────────────────────────────────

    public function update(Request $request, Tutorial $tutorial, Lesson $lesson)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'video_url'        => ['nullable', 'string', 'max:500', function ($attr, $value, $fail) {
                if ($value && !isValidYoutubeUrl($value)) {
                    $fail('رابط الفيديو يجب أن يكون رابط YouTube صالح (youtube.com أو youtu.be).');
                }
            }],
            'duration_minutes' => 'nullable|integer|min:0',
            'order'            => 'nullable|integer|min:0',
        ]);

        // Allow clearing the video_url by submitting an empty string
        if (array_key_exists('video_url', $data) && $data['video_url'] === '') {
            $data['video_url'] = null;
        }

        $lesson->update($data);
        return back()->with('success', 'تم تعديل الدرس');
    }

    // ── Admin: delete lesson ─────────────────────────────────────

    public function destroy(Tutorial $tutorial, Lesson $lesson)
    {
        $lesson->delete();
        $tutorial->update(['steps' => $tutorial->lessons()->count()]);
        return back()->with('success', 'تم حذف الدرس');
    }

    // ── Admin: reorder lessons ────────────────────────────────────

    /**
     * Bulk-reorder lessons for a tutorial.
     * Expects: { "order": [lessonId, lessonId, ...] }
     */
    public function reorder(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:lessons,id',
        ]);

        foreach ($request->order as $position => $lessonId) {
            $tutorial->lessons()
                ->where('id', $lessonId)
                ->update(['order' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }

    // ── Public: course / tutorial page ───────────────────────────

    public function show(Tutorial $tutorial)
    {
        // Enforces TutorialPolicy::view():
        //   admin   → always allowed (before() bypass)
        //   user    → always allowed
        //   student → only if tutorial is assigned to them (403 otherwise)
        Gate::authorize('view', $tutorial);

        $user = auth()->user();
        $tutorial->load(['category', 'lessons']);

        // Eager-load which lessons this user has already completed
        $completedLessonIds = $user->completedLessons()
            ->whereIn('lessons.id', $tutorial->lessons->pluck('id'))
            ->pluck('lessons.id')
            ->toArray();

        $progress = $tutorial->progressFor($user);

        // Check if user already has a certificate for this tutorial
        $certificate = null;
        if ($progress['is_complete'] && $tutorial->certificate_enabled) {
            $certificate = $tutorial->certificates()
                ->where('user_id', $user->id)
                ->first();
        }

        return view('course', compact('tutorial', 'completedLessonIds', 'progress', 'certificate'));
    }
}
