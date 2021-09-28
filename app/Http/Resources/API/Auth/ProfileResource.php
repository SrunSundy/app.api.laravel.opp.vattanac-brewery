<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return $this->only('outlet_name_en','outlet_name_kh', 'owner_name', 'contact_number',
            'region_code','sale_user_id','sale_user_name',
            'agent_code', 'house_no', 'street_no',
            'village', 'commune', 'district', 'image',
            'name_kh', 'outlet_name',
            'province', 'latitude', 'longitude');
    }
}
