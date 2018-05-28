<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\PortfolioTitleScope;

class Article extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PortfolioTitleScope);
    }

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }
}
