<?php

namespace App\Http\Requests\API\Outlet;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // return [
        //     "description" => "required|max:200"
        // ];
    }
}
