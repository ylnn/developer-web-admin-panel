<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\PortfolioTitleScope;

class Portfolio extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PortfolioTitleScope);
    }
}
