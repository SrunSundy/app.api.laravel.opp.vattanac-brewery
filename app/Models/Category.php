<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use App\Scopes\ActiveScope;
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
        if(request()->has("is_home_display")){
            $query->where("is_home_display", 1);
        }

        $query->where("name", "like", "%".$params["search"]."%");
       
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
