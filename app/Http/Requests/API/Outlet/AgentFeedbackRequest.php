<?php

namespace App\Http\Requests\API\Outlet;

use Illuminate\Foundation\Http\FormRequest;

class AgentFeedbackRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "sale_user_id" => "required",
            // "description" => "required|max:200"
        ];
    }
}
