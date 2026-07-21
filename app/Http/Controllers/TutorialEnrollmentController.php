<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialEnrollmentController extends Controller
{
    public function store(Request $request, Tutorial $tutorial)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $tutorial->users()->syncWithoutDetaching([$user->id => ['enrolled_at' => now()]]);

        return back()->with('status', 'تم التسجيل في التوتوريال');
    }

    public function destroy(Request $request, Tutorial $tutorial)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $tutorial->users()->detach($user->id);

        return back()->with('status', 'تم إلغاء التسجيل');
    }
}
