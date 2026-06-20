<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_name', 'account_number', 'bank_name',
        'branch_name', 'swift_code', 'type', 'is_default', 'is_verified'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
}
