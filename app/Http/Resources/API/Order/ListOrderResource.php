<?php

namespace App\Http\Resources\API\Order;

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
        return $this->only('id', 'order_number', 'is_urgent',
            'outlet_id','outlet_name', 'sub_total',
            'percent_off', 'amount_off', 'total',
            'sale_user_id','sale_user_name','promotion_id',
            'order_state_code', 'state_label','created_at');
    }
}
