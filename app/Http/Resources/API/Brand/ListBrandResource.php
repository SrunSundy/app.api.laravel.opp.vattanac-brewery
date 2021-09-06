<?php

namespace App\Http\Resources\API\Brand;

use Illuminate\Http\Resources\Json\JsonResource;

class ListBrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'name','image_url');
    }
}
