<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'outcome' => $this->outcome,
            'slug' => $this->slug,
            'image' => $this->image(),
            'status' => $this->status,
            'folders' => FolderResource::collect($this->folders),
            'created_at' => $this->created_at,
        ];
    }
}
