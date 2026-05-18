<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomePackage extends Model
{
    protected $fillable = [
        'jenis',
        'name',
        'badge',
        'is_featured',
        'price',
        'duration',
        'hotel',
        'features',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features'    => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function scopeUmroh($q)
    {
        return $q->where('jenis', 'umroh');
    }
    public function scopeHaji($q)
    {
        return $q->where('jenis', 'haji');
    }
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}
