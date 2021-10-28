<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\DefaultFormRequest;

class CreatePaymentRequest extends DefaultFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'encrypt_cart_id' => 'required|max:30',
            'transaction_id' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ];
    }
}
