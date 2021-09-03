<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */
    public function getCouponCodeAttribute()
    {
        return $this->promotion->coupon_code ?? '';
    }

    public function getAgentNameAttribute()
    {
        return $this->agent->fullname ?? '';
    }

    public function getOutletNameAttribute()
    {
        return $this->outlet->outlet_name ?? '';
    }

    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public function scopeFilter($query, $params)
    {
        return $query;
    }

    /*
    |------------------------------------------------------------ 
    | RELATIONS
    |------------------------------------------------------------
    */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function agent(){
        return $this->belongsTo(SaleUser::class, 'sale_user_id');
    }

    public function outlet(){
        return $this->belongsTo(Outlet::class , "outlet_id");
    }

    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function list($params){

        $list = self::filter($params);
        return listLimit($list, $params);
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
