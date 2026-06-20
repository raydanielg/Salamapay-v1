<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id', 'available', 'pending', 'reserved', 'currency'
    ];

    protected $casts = [
        'available' => 'decimal:2',
        'pending' => 'decimal:2',
        'reserved' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
