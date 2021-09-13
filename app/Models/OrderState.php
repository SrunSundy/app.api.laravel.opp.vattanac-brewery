<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    use HasFactory;

    public static function getValueByKey($key, $default = null)
    {
        $data = self::where('order_state_code', $key)->first();
        return $data->id ?? $default;
    }
}
