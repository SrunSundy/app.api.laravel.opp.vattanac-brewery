<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['outlet_id', 'promotion_id', 'is_urgent','created_by'];
    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_at = get_current_datetime() ?? null;
        });

        // create a event to happen on saving
        static::creating(function ($table) {
            $table->created_at = get_current_datetime() ?? null;
        });
    }

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
        $cart = self::filter($params)->first();
        $list = [];
        if($cart){
            $params["cart_id"] = $cart->id;
            $list = CartProduct::list($params);
        }
        return $list;
    }


    public static function productCnt($params){
        $cart = self::filter($params)->first();
        $cnt = 0;
        if($cart){
            $params["cart_id"] = $cart->id;
            $cnt = CartProduct::cnt($params);
        }
        return $cnt;

    }

    public static function store($request)
    {
        $fields = [
            'promotion_id',
            'is_urgent'
        ];

        $value = mapRequest($fields, $request);
        $data = self::updateOrCreate(['outlet_id' => auth()->user()->id], $value);
        
        if($data){
            //add outlet products to cart
            CartProduct::store($request, $data->id);
        }
        return $data;
    }
}
