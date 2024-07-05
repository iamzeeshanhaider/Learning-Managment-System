<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class StoreLessonRequest extends FormRequest
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
            'name' => 'required|string',
            'outcome' => 'required',
            'course_id' => 'required|integer|exists:courses,id',
            'status' => ['nullable', new EnumValue(GeneralStatus::class)],
            'image' => 'nullable|image',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id' => 'Kindly Select a Course',
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
