<?php

namespace App\Http\Resources\API\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderProductResource extends JsonResource
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
        return $this->only('id', 'quantity','unit_price'
                ,'product_variant_id', 'product_name'
                ,'sub_total', 'percent_off', 'amount_off'
                ,'total',
            );
    }
}
