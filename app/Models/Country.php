<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [

        'country_code',

        'country_name',

        'capital',

        'region',

        'subregion',

        'currency_code',

        'currency_name',

        'population',

        'latitude',

        'longitude',

        'flag'

    ];

    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}