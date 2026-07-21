<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Tutorial $tutorial)
    {
        return view('admin.lessons', [
            'tutorial' => $tutorial->load('lessons'),
        ]);
    }

    public function store(Request $request, Tutorial $tutorial)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'video_url'        => 'nullable|url|max:500',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $data['order'] = $tutorial->lessons()->max('order') + 1;
        $tutorial->lessons()->create($data);

        // update steps count
        $tutorial->update(['steps' => $tutorial->lessons()->count()]);

        return back()->with('success', 'تم إضافة الدرس');
    }

    public function update(Request $request, Tutorial $tutorial, Lesson $lesson)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'video_url'        => 'nullable|url|max:500',
            'duration_minutes' => 'nullable|integer|min:0',
            'order'            => 'nullable|integer|min:0',
        ]);

        $lesson->update($data);
        return back()->with('success', 'تم تعديل الدرس');
    }

    public function destroy(Tutorial $tutorial, Lesson $lesson)
    {
        $lesson->delete();
        $tutorial->update(['steps' => $tutorial->lessons()->count()]);
        return back()->with('success', 'تم حذف الدرس');
    }

    // Public course page
    public function show(Tutorial $tutorial)
    {
        $user = auth()->user();

        if ($user?->isStudent()) {
            $allowed = $user->tutorials()->where('tutorials.id', $tutorial->id)->exists();

            if (! $allowed) {
                abort(403);
            }
        }

        $tutorial->load(['category', 'lessons']);
        return view('course', compact('tutorial'));
    }
}
