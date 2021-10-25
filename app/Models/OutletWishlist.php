<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletWishlist extends Model
{
    use HasFactory;
    protected $fillable = ['outlet_id', 'product_id','created_by'];

     /*
    |------------------------------------------------------------ 
    | Relations
    |------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo(Product::class , "product_id");
    }

    /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */

    public function getNameAttribute(){
        if(filled($this->product))
            return $this->product->name;
        else 
            return "";
    }

    public function getImageUrlAttribute(){
        if(filled($this->product))
            return $this->product->image_url;
        else 
            return "";
       
    }

    public function getUnitPriceAttribute(){
        if(filled($this->product))
            return $this->product->unit_price;
        else 
            return "0.0";
    }

    public function getIsWishlistAttribute(){
        return true;
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

    public static function list($params)
    {
        $list = self::filter($params)->has("product");
        return listLimit($list, $params);
    }

    public static function isFavorited($params)
    {
        $is_existed =  self::where("outlet_id" , $params["outlet_id"])
                    ->where("product_id", $params["product_id"])
                    ->count();
        return $is_existed > 0;
    }

    public static function store($request , $id = null)
    {
        // request()->request->add([
        //     "outlet_id" => auth()->user()->id
        // ]);

        $request["outlet_id"] =  auth()->user()->id;
        $fields = [
            'outlet_id',
            'product_id'
        ];
        $value = mapRequest($fields, $request);
        $status = false;
        if ($id) {
            $status = self::updateOrCreate(['id' => $id], $value);
        } else {
            if(!self::isFavorited($request)){
                $status = self::create($value);
            }
        }
        return $status;
    }

    public static function remove($request){

        $status = self::where("outlet_id", auth()->user()->id)
                    ->where("product_id", request()->get("product_id"))
                    ->delete();
        return $status;
    }
}
