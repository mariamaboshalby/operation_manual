<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'tutorial_id',
        'certificate_number',
        'issued_at',
        'completed_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'issued_at'    => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // ── Relationships ────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tutorial(): BelongsTo
    {
        return $this->belongsTo(Tutorial::class);
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function isValid(): bool
    {
        return $this->status === 'valid';
    }

    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }
}
