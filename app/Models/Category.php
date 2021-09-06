<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory , ModelHelperTrait;

    
    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }

    public function scopeFilter($query, $params)
    {
        //return $query->where("outlet_id", $params["outlet_id"]);
    }

    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function list($params){

        $list = self::filter($params)->active();
        return listLimit($list, $params);
    }

}
