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

        $request->request->add([
            "contact_number" =>  request()->get("phone_number")
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
        $cnt = self::where("contact_number", request()->get("phone_number"))->count();
        return $cnt >= 1;
    }
}
