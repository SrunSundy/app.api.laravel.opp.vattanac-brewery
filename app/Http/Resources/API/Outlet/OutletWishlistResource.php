<?php

namespace App\Http\Resources\API\Outlet;

use Illuminate\Http\Resources\Json\JsonResource;

class OutletWishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'name','image_url',
            'product_id', 
            'unit_price','is_wishlist');
    }
}
