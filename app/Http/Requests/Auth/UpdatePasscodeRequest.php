<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\DefaultFormRequest;

class UpdatePasscodeRequest extends DefaultFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|min:6|max:6',
        ];
    }
}
