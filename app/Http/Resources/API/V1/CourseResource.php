<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->title,
            'code' => $this->code,
            'image' => $this->image(),
            'price' => formatMoney($this->price),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'location' => new LocationResource($this->location),
            'instructor' => UserResource::getInfoOnly($this->instructor),
            'module' => new ModuleResource($this->module),
            'quizzes' => QuizResource::collection($this->quizzes),
            // 'lessons' => LessonResource::collection($this->lessons),
            'lessons' => $this->lessons,
            'created_at' => $this->created_at,
            'pivot' => [
                'batch_id' => $this->pivot->batch_id,
                'course_id' => $this->pivot->course_id,
                'student_id' => $this->pivot->student_id,
                'batch_user_id' => $this->pivot->id,
                'created_at' => $this->pivot->created_at,
            ],
        ];
    }
}
