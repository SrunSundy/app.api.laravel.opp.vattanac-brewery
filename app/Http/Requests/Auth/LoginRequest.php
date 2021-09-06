<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\DefaultFormRequest;

class LoginRequest extends DefaultFormRequest
{
    protected function prepareForValidation() {
        $this->phone_number = phone($this->phone_number, 'kh');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|phone:kh',
            'password' => 'required',
        ];
    }
}
