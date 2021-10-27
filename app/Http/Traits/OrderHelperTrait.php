<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait OrderHelperTrait
{
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

    /**
     * @params int $id
     * @params string $prefix 'SO'
     */
    public static function generateOrderCode($id, $prefix = 'SO')
    {
        $char = intval($id / 99999);
        $number = $id % 99999;
        if ($number === 0) {
            $number = 99999;
            $char--;
        }

        $str = '';
        while ($char > 25) {
            $str .= 'Z';
            $char -= 25;
        }

        return $prefix . Carbon::now()->format('Ym') . sprintf("%05d", $number) . ($char > 0 ? chr($char + 64) : '') . $str;
    }
}
