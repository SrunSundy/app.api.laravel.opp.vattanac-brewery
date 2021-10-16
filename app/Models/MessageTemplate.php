<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

     /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function getMessageByKey($key)
    {
        $data = self::where([
            'code' => $key,
        ])->first();

        return $data->description ?? '';
    }

    public static function getNewOrderMessage($order)
    {
        $template = self::where('code', 'new_order')->first();

        if (!filled($template)) {
            return '';
        }

        $products = '';
        foreach ($order->order_products as $order_product) {
            if ($products) {
                $products .= "\n";
            }

            $products .= $order_product->product->name . ' : ' . $order_product->quantity . 'pt. x ' . currency($order_product->unit_price) . ' = ' . currency($order_product->sub_total);
        }

        $message = self::replaceMessage($template->description, [
            '[ORDER_CODE]' => $order->order_number ?? '',
            '[OUTLET_OWNER_NAME]' => $order->outlet->owner_name ?? '',
            '[OUTLET_NAME]' => $order->outlet->outlet_name ?? '',
            '[OUTLET_CONTACT_NUMBER]' => $order->outlet->contact_number,
            '[OUTLET_ADDRESS]' => $order->outlet->address,
            '[ORDER_DETAIL]' => $products,
            '[SUB_TOTAL]' => $order->sub_total,
            '[DISCOUNT]' => $order->total_discount,
            '[TOTAL]' => $order->total,
        ]);

        return $message;
    }

    /**
     * @param $text
     * @param $data
     * @return string
     */
    protected static function replaceMessage($text, $data)
    {
        return strtr($text, $data);
    }
}
