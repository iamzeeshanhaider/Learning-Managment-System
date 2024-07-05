<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'type' => $this->type,
            'slug' => $this->slug,
            'description' => $this->description,
            'seat_capacity' => $this->seat_capacity,
            'remaining_seat' => $this->remaining_seat,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
