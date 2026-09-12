<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    protected $fillable = [
        'tutorial_id',
        'title',
        'content',
        'video_url',
        'order',
        'duration_minutes',
    ];

    // ── Relationships ────────────────────────────────────────────

    public function tutorial(): BelongsTo
    {
        return $this->belongsTo(Tutorial::class);
    }

    /**
     * Users who have completed this lesson (pivot: lesson_user).
     */
    public function completedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }

    // ── Helpers ──────────────────────────────────────────────────

    /**
     * Check whether a specific user has completed this lesson.
     */
    public function isCompletedBy(User $user): bool
    {
        return $this->completedByUsers()
                    ->where('users.id', $user->id)
                    ->exists();
    }

    /**
     * Return the safe YouTube embed URL for this lesson's video_url,
     * or null if no valid YouTube URL is set.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        return getYoutubeEmbed($this->video_url);
    }
}
