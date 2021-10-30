<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Advertisement extends Model
{
    use HasFactory , ModelHelperTrait, SoftDeletes;

    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
    }


    public function scopeFilter($query, $params)
    {   
        $now = get_current_datetime();
        return $query->where(
            DB::raw("(CASE WHEN end_date <= '".$now."' THEN -1 WHEN end_date >= '".$now."' and start_date <= '".$now."' THEN 1 ELSE 0 END)"),
            1
        );
    }
    
    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function list($params){

        $list = self::filter($params)->active();
        return listLimit($list, $params);
    }
}
