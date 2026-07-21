<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'type'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(200)->height(200)->nonQueued();
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo', 'thumb') ?: null;
    }

    public function tutorials()
    {
        return $this->belongsToMany(Tutorial::class);
    }
}
