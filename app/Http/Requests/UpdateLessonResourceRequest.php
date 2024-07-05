<?php

namespace App\Http\Requests;

use App\Enums\LessonResourceType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UpdateLessonResourceRequest extends FormRequest
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
                'type' => ['required', new EnumValue(LessonResourceType::class)],
                'file' => 'required_unless:type,url|max:30000',
                'url' => 'required_if:type,url',
                'embed_code' => 'required_if:type,embed',
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
