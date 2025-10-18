<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingsClassification extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Simple scope
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}
