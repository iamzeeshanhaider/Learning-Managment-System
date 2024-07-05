<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UpdateCourseRequest extends FormRequest
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
            'title' => 'required|string',
            'status' => ['required', new EnumValue(GeneralStatus::class)],
            'location_id' => 'required|exists:locations,id',
            'instructor_id' => 'required|exists:users,id',
            'course_master_id' => 'required|exists:course_masters,id',
            'module_id' => 'nullable|exists:modules,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'price' => 'required|integer',
            'image' => 'nullable|image',
        ];
    }

    public function messages(): array
    {
        return [
            'location_id' => 'Kindly Select a Location',
            'instructor_id' => 'Kindly Select an Instructor',
            'course_master_id' => 'Kindly Select a Course Master',
            'module_id' => 'Kindly Select a Module',
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
