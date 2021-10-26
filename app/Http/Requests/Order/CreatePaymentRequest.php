<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\DefaultRequest;

class CreatePaymentRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'encrypt_cart_id' => 'required',
            'transaction_id' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ];
    }
}
