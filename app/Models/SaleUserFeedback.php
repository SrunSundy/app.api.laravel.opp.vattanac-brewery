<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleUserFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'outlet_id', 
        'sale_user_id',
        'type', 
        'description',
        'deleted_by',
        'updated_at',
        'created_at',
        'deleted_at'
    ];
     /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_at = get_current_datetime() ?? null;
        });

        // create a event to happen on saving
        static::creating(function ($table) {
            $table->created_at = get_current_datetime() ?? null;
        });
    }

    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function store($request)
    {
        // request()->request->add([
        //     "outlet_id" => auth()->user()->id,
        // ]);

        $request["outlet_id"] = auth()->user()->id;

        $fields = [
            'outlet_id',
            'type',
            'description',
            'sale_user_id'
        ];

        $value = mapRequest($fields, $request);
        $data = self::create($value);
        return $data;
    }

}
