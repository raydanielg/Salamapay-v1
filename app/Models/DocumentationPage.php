<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentationPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'category',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }
}
