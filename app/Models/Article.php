<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}