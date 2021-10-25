<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOutlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name', 
        'outlet_name', 
        'contact_number'
    ];
     /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */

    public static function store($request)
    {

        request()->merge([
            'contact_number' => phone($request["phone_number"], 'kh'),
        ]);
        $fields = [
            'owner_name',
            'outlet_name',
            'contact_number'
        ];

        $value = mapRequest($fields, $request);
        $data = self::create($value);
        
        return $data;
    }   

    public static function isPhoneNumberExisted($request){
        $phone = phone($request["phone_number"], 'kh');
        $cnt = self::where("contact_number", $phone)->count();
        return $cnt >= 1;
    }
}
