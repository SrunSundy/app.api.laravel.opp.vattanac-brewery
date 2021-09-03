<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public static function list($param){

        $list = self::select("id", "");

        return listLimit($list , $param);
        
    }

    public static function updateStatus($param){
        
        return self::where("order_number", $param["order_number"])
        ->update([
            "state_id" => $param["state_id"]
        ]);
    }

    public static function isOrderExisted($param){

        $count = self::where("order_number", $param["order_number"])->count();
        return ((int)$count > 0);
    }
}
