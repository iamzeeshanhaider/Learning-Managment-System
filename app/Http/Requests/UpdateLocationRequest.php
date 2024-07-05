<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatus;
use App\Enums\LocationTypes;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UpdateLocationRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'description' => 'nullable',
            'file' => 'required|max:30000',
            'seat_capacity' => 'required',
            'status' => ['nullable', new EnumValue(GeneralStatus::class)],
            'type' => ['nullable', new EnumValue(LocationTypes::class)],
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
