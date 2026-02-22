<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'provider',
        'url',
        'company_id',
        'rating',
        'reviews_count',
        'sync_status',
        'sync_progress',
        'sync_error',
        'last_synced_at',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
