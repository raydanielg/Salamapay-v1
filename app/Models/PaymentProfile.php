<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'business_name',
        'business_type',
        'business_tin',
        'phone',
        'email',
        'website_url',
        'logo',
        'description',
        'color',
        'language',
        'page_type',
        'allow_custom_amount',
        'products',
        'success_url',
        'webhook_url',
        'require_email',
        'accepted_methods',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'allow_custom_amount' => 'boolean',
            'require_email' => 'boolean',
            'products' => 'array',
            'accepted_methods' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentLinks(): HasMany
    {
        return $this->hasMany(PaymentLink::class, 'profile_id');
    }

    protected static function booted(): void
    {
        static::saving(function ($profile) {
            if ($profile->is_default) {
                static::where('user_id', $profile->user_id)
                    ->where('id', '!=', $profile->id)
                    ->update(['is_default' => false]);
            }
        });
    }
}
