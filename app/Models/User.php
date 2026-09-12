<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Role helpers ─────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // ── Relationships ────────────────────────────────────────────

    /**
     * Tutorials the user is enrolled in / assigned to.
     */
    public function tutorials(): BelongsToMany
    {
        return $this->belongsToMany(Tutorial::class)
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }

    /**
     * Lessons the user has completed (pivot: lesson_user).
     */
    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }

    /**
     * Certificates earned by this user.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
