<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeSlide extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'description',
        'btn_primary_text',
        'btn_secondary_text',
        'stats',
        'image',
        'overlay_color',
        'bg_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'stats'     => 'array',
        'is_active' => 'boolean',
    ];
}
