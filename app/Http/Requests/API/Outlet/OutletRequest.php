<?php

namespace App\Http\Requests\API\Outlet;

use Illuminate\Foundation\Http\FormRequest;

class OutletRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        request()->merge([
            'contact_number' => phone($this->phone_number, 'kh'),
        ]);
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "owner_name" => "required|max:100",
            "outlet_name" => "required|max:150", 
            "phone_number" => "required|max:50|phone:kh"
            //
        ];
    }
}
