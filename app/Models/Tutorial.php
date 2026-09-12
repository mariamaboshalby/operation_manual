<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Tutorial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'thumb_class',
        'level',
        'duration',
        'steps',
        'certificate_enabled',
    ];

    protected function casts(): array
    {
        return [
            'certificate_enabled' => 'boolean',
        ];
    }

    // ── Media ────────────────────────────────────────────────────

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(400)->height(250)->nonQueued();
    }

    // ── Relationships ────────────────────────────────────────────

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    // ── Accessors ────────────────────────────────────────────────

    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'thumb') ?: null;
    }

    public function getLevelBadgeAttribute(): string
    {
        return match ($this->level) {
            'beginner'     => 'badge-beginner',
            'intermediate' => 'badge-intermediate',
            'advanced'     => 'badge-advanced',
            default        => 'badge-beginner',
        };
    }

    // ── Progress ─────────────────────────────────────────────────

    /**
     * Calculate tutorial progress for a given user.
     *
     * Returns an array:
     *   total       int    – total lesson count
     *   completed   int    – lessons completed by this user
     *   remaining   int    – lessons not yet completed
     *   percentage  int    – 0–100
     *   is_complete bool   – true only when total > 0 AND all completed
     *
     * A tutorial with zero lessons is NEVER considered complete.
     */
    public function progressFor(User $user): array
    {
        $lessons = $this->lessons; // already loaded or will be lazy-loaded

        $total = $lessons->count();

        if ($total === 0) {
            return [
                'total'       => 0,
                'completed'   => 0,
                'remaining'   => 0,
                'percentage'  => 0,
                'is_complete' => false,
            ];
        }

        $lessonIds = $lessons->pluck('id');

        $completedCount = $user->completedLessons()
            ->whereIn('lessons.id', $lessonIds)
            ->count();

        $percentage  = (int) round(($completedCount / $total) * 100);
        $isComplete  = $completedCount === $total;

        return [
            'total'       => $total,
            'completed'   => $completedCount,
            'remaining'   => $total - $completedCount,
            'percentage'  => $percentage,
            'is_complete' => $isComplete,
        ];
    }
}
