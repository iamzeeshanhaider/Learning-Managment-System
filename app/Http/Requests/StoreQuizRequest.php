<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatus;
use App\Enums\QuizTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class StoreQuizRequest extends FormRequest
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
    public function rules()
    {
        return [
            'question' => 'required|string',
            'instruction' => 'nullable',
            'obtainable_score' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'type' => ['required', new EnumValue(QuizTypes::class)],
            'lesson_id' => 'required|exists:lessons,id',
            'status' => ['required', new EnumValue(GeneralStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'lesson_id' => 'Kindly Select a Lesson',
            'type' => 'Kindly Select a Quiz Type',
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
