<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'obtainable_points' => $this->end_time,
            'attempts' => $this->end_time,
            'duration' => $this->format_duration,
            // 'course_id' => $this->course,
            // 'batch_id' => $this->batch,
            'status' => $this->status,
            'is_average' => $this->is_average,
            'created_at' => $this->created_at,
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}
