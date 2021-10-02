<?php

namespace App\Http\Resources\API\SaleUser;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailSaleUSerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'name','contact_number',
            'agent_number', 'telegram_user_no');
    }
}
