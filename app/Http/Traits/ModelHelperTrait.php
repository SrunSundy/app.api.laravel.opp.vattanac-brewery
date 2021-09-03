<?php

namespace App\Http\Traits;

trait ModelHelperTrait
{
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
}
