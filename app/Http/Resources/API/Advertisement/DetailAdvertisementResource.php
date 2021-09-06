<?php

namespace App\Http\Resources\API\Advertisement;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailAdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'title','image_url','description');
    }
}
