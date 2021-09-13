<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait ModelHelperTrait
{   
    /**
     * @param $query
     * @param int $active
     * @return mixed
     */
    public function scopeActive($query, $active = 1)
    {
        return $query->where('is_enable', $active);
    }
    
    /**
     * Create or Update Data
     * 
     * @params $request
     * @params $fields
     */
    public static function saveDataByField($request, $fields = [])
    {
        if (filled($fields)) {
            $data = self::updateOrCreate($fields, $request);
        } else {
            $data = self::create($request);
        }

        return $data;
    }

    /**
     * Create or Update Data
     * 
     * @params $request
     * @params $id
     */
    public static function saveDataById($request, $id = null)
    {
        if (filled($id)) {
            $data = self::updateOrCreate(['id' => $id], $request);
        } else {
            $data = self::create($request);
        }

        return $data;
    }


    /**
     * 
     * @params int $quantity
     * @params float $unit_price
     */
    public static function calculateSubTotalAmount($quantity, $unit_price)
    {
        return $unit_price * $quantity;
    }
    /**
     * 
     * @params float $sub_total
     * @params float $discount
     * @params int $discount_type; 0 = Fixed Amount, 1 = Percentage
     */
    public static function calculateTotalAmount($sub_total, $discount = 0, $discount_type = 0)
    {
        $discount_amount = 0;
        if ($discount_type === 0) {
            $discount_amount = $discount;
        } else if ($discount_type === 1) {
            $discount_amount = ($sub_total * $discount) / 100;
        }

        return $sub_total - $discount_amount;
    }


   
}
