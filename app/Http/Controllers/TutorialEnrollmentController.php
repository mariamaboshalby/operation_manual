<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialEnrollmentController extends Controller
{
    /**
     * Enroll the authenticated user in a tutorial.
     *
     * Students cannot self-enroll — their tutorials are assigned by an admin.
     */
    public function store(Request $request, Tutorial $tutorial)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Students are not permitted to enroll themselves
        if ($user->isStudent()) {
            abort(403, 'الطلاب لا يمكنهم التسجيل بأنفسهم — يتم التعيين من الأدمن');
        }

        $tutorial->users()->syncWithoutDetaching([$user->id => ['enrolled_at' => now()]]);

        return back()->with('status', 'تم التسجيل في التوتوريال');
    }

    /**
     * Unenroll the authenticated user from a tutorial.
     *
     * Students cannot unenroll themselves — only admin manages their assignments.
     */
    public function destroy(Request $request, Tutorial $tutorial)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Students are not permitted to unenroll themselves
        if ($user->isStudent()) {
            abort(403, 'الطلاب لا يمكنهم إلغاء التسجيل — يتم التعيين من الأدمن');
        }

        $tutorial->users()->detach($user->id);

        return back()->with('status', 'تم إلغاء التسجيل');
    }
}
