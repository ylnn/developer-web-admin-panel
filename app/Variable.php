<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\VariableKeyScope;

class Variable extends Model
{
  protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new VariableKeyScope);
    }   
}
