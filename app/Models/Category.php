<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
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
    public function scopeFilter($query, $params)
    {
        //return $query->where("outlet_id", $params["outlet_id"]);
    }

    public function scopeDetailFilter($query, $params)
    {
        return $query->where("id" , $params["id"]);
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

    public static function detail($params){
        $data = self::detailFilter($params)->active()->first();
        return $data;
    }

}
