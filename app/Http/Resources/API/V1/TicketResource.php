<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'slug' => $this->slug,
            // 'priority' => $this->priority,
            'message' => $this->message,
            'status' => $this->status,
            'image' => $this->image(),
            'comments' => TicketCommentResource::collection($this->comments),
            'assigned_instructor' => $this->instructor ? UserResource::getInfoOnly($this->instructor) : null,
            'category' => new TicketCategoryResource($this->category),
            'created_at' => $this->created_at,
        ];
    }
}
