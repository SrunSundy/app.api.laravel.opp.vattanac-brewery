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
        return $this->only('id', 'fullname','phone',
            'agent_code', 'telegram_user_no');
    }
}
