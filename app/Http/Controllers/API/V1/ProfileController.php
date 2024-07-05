<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\Ethnicity;
use App\Enums\Gender;
use App\Enums\UKStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\UserResource;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        try {
            return response()->json([
                'message' => 'Profile Retrived',
                'user' => new UserResource($this->user),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request)
    {
        // Validation rules for the request
        $validationRules = [
            // Personal Information
            'phone' => 'nullable',
            'designation' => 'nullable',
            'calendar_id' => 'nullable',
            'name' => 'required|max:100',
            'lname' => 'required|max:100',
            'username' => 'required|unique:users,username,' . $this->user->id,

            // Demographic information
            'city' => 'nullable',
            'address' => 'nullable',
            'dob' => 'required|date',
            'country_id' => 'required|exists:countries,id',
            'gender' => ['required', new EnumValue(Gender::class)],
            'ethnicity' => ['required', new EnumValue(Ethnicity::class)],
            'uk_status' => ['nullable', new EnumValue(UKStatus::class)],

            // Next of Kin Information
            'nok_email' => 'nullable|email',
            'nok_name' => 'required|max:100',
            'nok_relation' => 'required|max:100',
            'nok_phone' => 'required_if:nok_email,!=,null|max:100',

            // Career Information
           // 'att_level' => 'nullable',
            'signed_doc' => 'nullable',
            'qualification' => 'required',
            'employment_status' => 'nullable',
            'years_of_experience' => 'nullable',
            'how_did_you_hear_about_us' => 'nullable',
            'professional_registration_body' => 'nullable',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {

            DB::beginTransaction();

            // Update personal and demographic information
            $this->user->update($request->only([
                'name', 'lname', 'phone', 'username', 'designation',
                'phone', 'calendar_id', 'dob', 'gender',
                'country_id', 'city', 'address', 'ethnicity', 'uk_status'
            ]));

            // Update bio (Next of Kin and Career Information)
            $this->user->bio()->update($request->only([
                'nok_name', 'nok_relation', 'nok_email', 'nok_phone',
                'qualification', 'employment_status', 'years_of_experience', 'professional_registration_body',
                'how_did_you_hear_about_us', 'signed_doc'
            ]));

            DB::commit();

            return response()->json([
                'message' => 'Profile Updated',
                'user' => new UserResource($this->user),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }
}
