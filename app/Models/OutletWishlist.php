<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletWishlist extends Model
{
    use HasFactory;

    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public function scopeFilter($query, $params)
    {   
        $query->where("outlet_id", auth()->user()->id);
    }

    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */

    public static function list($params)
    {
        $list = self::filter($params);
        return listLimit($list, $params);
    }

    public static function store($request , $id = null)
    {
        $fields = [
            'outlet_id',
            'product_id'
        ];
        $value = mapRequest($fields, $request);
        if ($id) {
            $data = self::updateOrCreate(['id' => $id], $value);
        } else {
            $data = self::create($value);
        }
        return $data;
    }
}
