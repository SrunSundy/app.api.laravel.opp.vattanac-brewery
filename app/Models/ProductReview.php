<?php

namespace App\Models;

use App\Http\Requests\API\Product\ProductReviewRequest;
use App\Http\Traits\ModelHelperTrait;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory , ModelHelperTrait;

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
    }

    public function scopeFilter($query, $params)
    {   
        //return $query->where($params["product_id"]);
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
        dd($value);
        if ($id) {
            $data = self::updateOrCreate(['id' => $id], $value);
        } else {
            $data = self::create($value);
        }
        return $data;
    }


}
