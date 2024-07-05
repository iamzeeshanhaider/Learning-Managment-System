<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class StoreBatchEnrol extends FormRequest
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
            'batch_id' => 'required|exists:batches,id',
            'course_id' => 'required|exists:batches,id',
            'students' => 'required|array',
            'action' => 'required|in:enrol,unenrol',
            'fee' => 'nullable|numeric',
            'fee_after_discount' => 'nullable|numeric|lte:fee',
            'discount' => 'nullable|numeric',
            'next_payment_due_date' => 'nullable|date',
            'amount_paid' => 'required|numeric|lte:fee',
            'proof_of_payment' => 'nullable|mimes:jpeg,bmp,png,gif,svg,pdf',
            'invoice_id' => 'nullable|string',
            'payment_mode' => 'nullable|in:cash,cheque,card,mobile_wallet,bank_transfer,others',
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
