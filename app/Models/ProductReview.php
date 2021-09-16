<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory , ModelHelperTrait;

    protected $fillable = ['outlet_id', 'product_id',
        'rating','title',
        'description','created_by'];

    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('product_based', function (Builder $builder) {
            $product_id = request()->route('product');
            if ($product_id) {
                $builder->where('product_id', $product_id);
            }
        });
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
        //return $query->where($params["product_id"]);
    }

     /*
    |------------------------------------------------------------ 
    | Relations
    |------------------------------------------------------------
    */

    public function outlet(){
        return $this->belongsTo(Outlet::class , "outlet_id");
    }

     /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */

    public function getOutletNameAttribute(){
        return $this->outlet->owner_name;
    }

    public function getOutletImageAttribute(){
        return $this->outlet->image;
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

    public static function avgReview()
    {
        $avg = self::sum('rating') / self::count();
        return $avg;
    }

    public static function cntReview(){
        return self::count();
    }

    public static function store($request , $id = null)
    {
        $fields = [
            'outlet_id',
            'product_id',
            'rating',
            'title',
            'description'
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
