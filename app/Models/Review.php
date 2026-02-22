<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'integration_id',
        'external_id',
        'author_name',
        'rating',
        'text',
        'published_at',
        'raw',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'raw' => 'array',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
