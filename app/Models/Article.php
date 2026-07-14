<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'source',
        'author',
        'description',
        'content',
        'image',
        'url',
        'published_at'
    ];
}