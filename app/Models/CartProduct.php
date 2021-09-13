<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity',
    ];

     /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public function scopeFilter($query, $params)
    {   
        $query->where("cart_id", $params["cart_id"]);
    }

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function list($params)
    {
        $list = self::filter($params);
        return listLimit($list, $params);
    }

    public static function store($request, $cart_id)
    {
        $cart_product = self::where([
            'cart_id' => $cart_id,
            'product_variant_id' => $request->product_variant_id,
        ])->first();

        if ($cart_product) {
            $cart_product->update([
                'quantity' => $cart_product->quantity + $request->quantity,
            ]);
        } else {
            $cart_product = self::create($request->only('product_variant_id', 'quantity') + ['cart_id' => $cart_id]);
        }

        return $cart_product;
    }
}
