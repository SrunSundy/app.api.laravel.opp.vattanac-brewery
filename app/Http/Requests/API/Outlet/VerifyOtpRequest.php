<?php

namespace App\Http\Requests\API\Outlet;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_number' => 'required',
            'otp' => 'required',
        ];
    }
}
