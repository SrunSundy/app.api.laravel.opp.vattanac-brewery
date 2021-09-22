<?php

namespace App\Http\Resources\API\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'outlet_id','promotion_id', 'is_urgent', 
            'outlet_name', 'outlet_address', 'outlet_phone_number',
            'outlet_lat', 'outlet_lng', 'agent_name',
            'agent_id','agent_code', 'agent_phone_number',
            'list','sub_total');
    }
}
