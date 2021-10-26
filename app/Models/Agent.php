<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory, ModelHelperTrait;

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function account()
    {
        return $this->hasOne(AgentAccount::class);
    }

    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function detail()
    {

        if (!auth()->user()->agent_id) return null;
        $item =  self::where("id", auth()->user()->agent_id)->first();
        return $item;
    }
}
