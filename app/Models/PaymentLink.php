<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLink extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
        'title',
        'description',
        'custom_fields',
        'amount',
        'currency',
        'slug',
        'is_active',
        'usage_count',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
            'expires_at' => 'datetime',
            'custom_fields' => 'array',
        ];
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(PaymentProfile::class, 'profile_id');
    }

    public function merchantName(): string
    {
        if ($this->profile && $this->profile->business_name) {
            return $this->profile->business_name;
        }
        $user = $this->user;
        return $user->business_name ?? ($user->first_name . ' ' . $user->last_name);
    }
}
