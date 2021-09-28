<?php

namespace App\Models;

use App\Http\Traits\ModelHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleUser extends Model
{
    use HasFactory, ModelHelperTrait;

    /*
    |------------------------------------------------------------ 
    | SCOPES
    |------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------ 
    | Relations
    |------------------------------------------------------------
    */
    public function telegram(){
        return $this->belongsTo(TelegramUser::class, "telegram_user_id");
    }

    /*
    |------------------------------------------------------------ 
    | ACCESSORS
    |------------------------------------------------------------
    */
    public function getAgentCodeAttribute(){
        return $this->agent_number;
    }

    public function getTelegramUserNoAttribute(){
        return $this->telegram->telegram_user_id;
    }




    /*
    |------------------------------------------------------------ 
    | STATIC METHODS
    |------------------------------------------------------------
    */
    public static function detail(){

        if(!auth()->user()->sale_user_id) return null;
        $item =  self::where("id", auth()->user()->sale_user_id)->first();
        return $item;
    }
}
