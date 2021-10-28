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
    | ACCESSORS
    |------------------------------------------------------------
    */
    public function getTotalAttribute()
    {
        $total = 0;

        foreach ($this->cart_products as $cart_product) {
            $total += ($cart_product->quantity * $cart_product->unit_price);
        }

        return $total;
    }

    public function getOutletNameAttribute()
    {
        return $this->outlet->outlet_name ?? '';
    }

    public function getOutletAddressAttribute()
    {
        return ($this->outlet->house_no.',' ?? '') .
        ($this->outlet->street_no.',' ?? '').
        ($this->outlet->province.',' ?? '').
        ($this->outlet->district.',' ?? '').
        ($this->outlet->commune.',' ?? '').
        ($this->outlet->village.',' ?? '');
    }

    public function getOutletPhoneNumberAttribute()
    {
        return $this->outlet->contact_number ?? '';
    }

    public function getOutletLatAttribute()
    {
        return $this->outlet->latitude ?? '';
    }

    public function getOutletLngAttribute()
    {
        return $this->outlet->longitude ?? '';
    }

    public function getAgentNameAttribute(){
        return $this->outlet->agent->name ?? '';
    }

    public function getAgentCodeAttribute(){
        return $this->outlet->agent->agent_number ?? '';
    }

    public function getAgentPhoneNumberAttribute(){
        return $this->outlet->agent->contact_number ?? '';
    }

    public function getAgentIdAttribute(){
        return $this->outlet->agent_id ?? '';
    }

    /*
    |------------------------------------------------------------ 
    | RELATIONS
    |------------------------------------------------------------
    */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function cart_products()
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }

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

    public static function detail($params){
        return self::filter($params)->first();
    }


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

    public static function reorder($request)
    {
        $fields = [
            'promotion_id',
            'is_urgent'
        ];
        $value = mapRequest($fields, $request);
        $data = self::updateOrCreate(['outlet_id' => auth()->user()->id], $value);
        
        if($data){
            CartProduct::removeAll($data->id);
            //add outlet products to cart
            CartProduct::stores($request, $data->id);
        }
        return $data;
    }


    public static function removeAll($params){
        $cart = self::filter($params)->first();
        if($cart){
            CartProduct::removeAll($cart->id);
        }
    }

    public static function remove($params)
    {
        $cart = self::filter($params)->first();
        if($cart){
            CartProduct::remove( $cart->id ,request()->get("product_id"));
        }
        
    }
}
