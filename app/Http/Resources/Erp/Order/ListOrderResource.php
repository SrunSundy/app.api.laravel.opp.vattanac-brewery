<?php

namespace App\Http\Resources\Erp\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'order_number','outlet_name', 'agent_name', 'coupon_code',);
        // return parent::toArray($request);
    }
}
