<?php

namespace App\Http\Resources\API\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class ListNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'notifiable_id', 'notifiable_type',
            'message', 'data', 'is_public', 'is_read');
    }
}
