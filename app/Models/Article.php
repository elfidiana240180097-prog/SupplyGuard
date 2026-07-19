<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [

        'country_id',
        'title',
        'slug',
        'source',
        'author',
        'summary',
        'description',
        'content',
        'image',
        'url',
        'status',
        'published_at'

    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}