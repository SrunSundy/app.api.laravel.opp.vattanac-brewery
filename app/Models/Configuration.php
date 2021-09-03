<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    const ERP_URL = 'erp_order_url';

    /*
    |--------------------------------------------------------------------------
    | STATIC FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Get resource value by key
     *
     * @param $key
     * @param null $default
     */
    public static function getValueByKey($key, $default = null)
    {
        $data = self::where('config_key', $key)->first();
        return $data->config_value ?? $default;
    }
}
