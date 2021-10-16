<?php

namespace App\Http\Requests\API\Outlet;

use App\Http\Requests\DefaultFormRequest;
use App\Models\Outlet;

class ForgotPasswordRequest extends DefaultFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_number' => 'required|exists:' . Outlet::getTableName() . ',contact_number|phone:' . request()->get('country_code'),
            'forgot_password_token' => 'required',
            'new_password' => 'required|min:6|max:6',
        ];
    }
}
