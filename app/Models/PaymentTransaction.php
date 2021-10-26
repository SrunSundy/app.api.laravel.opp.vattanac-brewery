<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_id',
        'outlet_id',
        'cart_id',
        'encrypt_cart_id',
        'transaction_id',
        'amount',
        'status',
    ];
}
