<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\GeneralStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|max:100',
            'lname' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'username' => 'required|unique:users,username',
            'password' => 'nullable',

            'designation' => 'nullable',
            'dob' => 'nullable|date',
            'country_id' => 'required|exists:countries,id',
            'city' => 'nullable',
            'address' => 'nullable',

            'role' => 'nullable|exists:roles,id',
            'permissions' => 'nullable|array',
            'gender' => ['required', new EnumValue(Gender::class)],
            'status' => ['nullable', new EnumValue(GeneralStatus::class)],
            'image' => 'nullable|image',

            'calendar_id' => 'nullable|string',
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
