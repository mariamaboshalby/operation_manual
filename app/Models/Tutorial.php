<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Tutorial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['category_id', 'title', 'description', 'thumb_class', 'level', 'duration', 'steps'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
             ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(400)
             ->height(250)
             ->nonQueued();
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('enrolled_at');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'thumb') ?: null;
    }

    public function getLevelBadgeAttribute(): string
    {
        return match($this->level) {
            'beginner'     => 'badge-beginner',
            'intermediate' => 'badge-intermediate',
            'advanced'     => 'badge-advanced',
            default        => 'badge-beginner',
        };
    }
}
