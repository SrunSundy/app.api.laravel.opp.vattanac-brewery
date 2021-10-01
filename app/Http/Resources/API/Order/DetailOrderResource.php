<?php

namespace App\Http\Resources\API\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'order_number', 'is_urgent',
        'outlet_id','outlet_name', 'sub_total',
        'percent_off', 'amount_off', 'total',
        'agent_id','agent_name','agent_phone','agent_code','promotion_id',
        'order_state_code', 'state_label','created_at'
        )+ [
             'products' => ListOrderProductResource::collection($this->products)
        ];
    }
}
