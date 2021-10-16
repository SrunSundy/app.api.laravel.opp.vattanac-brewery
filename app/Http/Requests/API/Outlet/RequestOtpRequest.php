<?php

namespace App\Http\Requests\API\Outlet;

use App\Http\Requests\DefaultFormRequest;
use App\Models\Outlet;

class RequestOtpRequest extends DefaultFormRequest
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
        ];
    }
}
