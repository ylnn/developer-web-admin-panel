<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ArticleTitleScope;

class Article extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ArticleTitleScope);
    }

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }
}
