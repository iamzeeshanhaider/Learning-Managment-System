<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use App\Models\LessonFolder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UpdateFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Lesson $lesson, LessonFolder $folder)
    {
        return [
            'name' => 'required|unique:lesson_folders,name,' . $folder->id . ',id,lesson_id,' . $lesson->id,
            'is_published' => 'nullable'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        LaravelFlash::withError('OOPS! ' . $validator->errors()->first());
    }
}
