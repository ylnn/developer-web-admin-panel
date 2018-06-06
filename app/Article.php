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
    
    public function getSummaryAttribute()
    {
        // strip tags, str_limit, remove image tags with preg_replace...
        return preg_replace('/\[image\|?(.*?)\]/', '', str_limit(strip_tags($this->description), 300));
    }
}
