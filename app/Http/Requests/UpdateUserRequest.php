<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user()->id,
            'username' => 'required|unique:users,username,'.$this->user()->id,
            'password' => 'nullable',
            'designation' => 'nullable',
            'role' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'status' => ['required', new EnumValue(GeneralStatus::class)],
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
