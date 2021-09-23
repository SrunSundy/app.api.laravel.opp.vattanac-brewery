<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

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
    | RELATIONS
    |------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo(Product::class, "product_variant_id");
    }

     /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */
    public function getProductNameAttribute(){
        return $this->product->name ?? '';
    }

    public function getImageUrlAttribute(){
        return $this->product->image_url ?? '';
    }

    public function getProductIdAttribute(){
        return $this->product_variant_id ?? '';
    }

    public function getUnitPriceAttribute(){
        return $this->product->unit_price ?? '0';
    }


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

    public static function cnt($params){
        return self::filter($params)->count();
    }

    public static function list($params)
    {
        $list = self::filter($params);
        return listLimit($list, $params);
    }

    public static function store($request, $cart_id)
    {
        $cart_product = self::where([
            'cart_id' => $cart_id,
            'product_variant_id' => $request->product_id,
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

    public static function stores($request, $cart_id){
        $items = $request["products"];
        $products = [];
        foreach($items as $item){

            $cart_product = self::where([
                'cart_id' => $cart_id,
                'product_variant_id' => $item["product_variant_id"],
            ])->first();
               
            if ($cart_product) {
                $cart_product->update([
                    'quantity' => $cart_product->quantity + $item["quantity"],
                ]);
            } else {
                array_push($products , [
                    'product_variant_id' => $item["product_variant_id"],
                    'quantity' => $item["quantity"],
                    'cart_id' => $cart_id
                ]);
            }
            
        }
        self::insert($products);
    }

    public static function remove( $cartId ,$productId)
    {
        $cart_product = self::where([
            'cart_id' => $cartId,
            'product_variant_id' => $productId,
        ])->first();

        if($cart_product->quantity > 1){
            $cart_product->update([
                'quantity' => $cart_product->quantity - request()->get("quantity"),
            ]);
        }else{
            $cart_product->delete();
        }
     
        return $cart_product;
    }

    public static function removeAll($cartId){

        self::where("cart_id" , $cartId)->delete();
    }
}
