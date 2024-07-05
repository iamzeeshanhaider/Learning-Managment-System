<?php

namespace App\Http\Livewire\Backend;

use App\Enums\Ethnicity;
use App\Enums\Gender;
use App\Enums\UKStatus;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserBioData extends Component
{
    public $previousStep;
    public $currentStep = 'personal_info';

    public $user;
    public $disabled = false;

    // personal_info
    public $name;
    public $lname;
    public $username;
    public $email; // readonly
    public $dob;
    public $gender;
    public $phone;
    public $student_id; // readonly
    public $designation;

    // student_info
    public $country_id;
    public $city;
    public $address;
    public $ethnicity;
    public $uk_status;

    // student_info - Next of Kin
    public $nok_name;
    public $nok_relation;
    public $nok_phone;
    public $nok_email;

    // career_info
    public $qualification;
    public $employment_status;
    public $years_of_experience;
    public $professional_registration_body;
    public $how_did_you_hear_about_us;
    //public $att_level;
    public bool $signed_doc;

    public $calendar_id;


    public function mount()
    {
        $this->user = User::find(Auth::id());

        $this->name = $this->user->name;
        $this->lname = $this->user->lname;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->dob = $this->user->dob();
        $this->gender = $this->user->gender;
        $this->phone = $this->user->phone;
        $this->designation = $this->user->designation;

        $this->country_id = $this->user->country_id;
        $this->city = $this->user->city;
        $this->address = $this->user->address;
        $this->ethnicity = $this->user->ethnicity;
        $this->uk_status = $this->user->uk_status;
        $this->calendar_id = $this->user->calendar_id;

        if ($this->user->bio) {
            $this->student_id = $this->user->bio->student_id;
            $this->nok_name = $this->user->bio->nok_name;
            $this->nok_relation = $this->user->bio->nok_relation;
            $this->nok_phone = $this->user->bio->nok_phone;
            $this->nok_email = $this->user->bio->nok_email;

            $this->qualification = $this->user->bio->qualification;
            $this->employment_status = $this->user->bio->employment_status;
            $this->years_of_experience = $this->user->bio->years_of_experience;
            $this->professional_registration_body = $this->user->bio->professional_registration_body;
            $this->how_did_you_hear_about_us = $this->user->bio->how_did_you_hear_about_us;
            $this->att_level = null;
            $this->signed_doc = (bool) $this->user->bio->signed_doc;
        }
    }

    public function goToPreviousStep()
    {
        $this->currentStep = $this->previousStep;

        $this->previousStep = $this->previousStep === 'personal_info' ? null : 'personal_info';
    }

    public function goToNextStep()
    {
        $validationRules = [];
        $type = 'profile';
        $nextStepOrRedirect = null;

        switch ($this->currentStep) {
            case 'personal_info':
                $validationRules = [
                    'name' => 'required|max:100',
                    'lname' => 'required|max:100',
                    'username' => 'required|unique:users,username,' . $this->user->id,
                    'email' => 'required|email|unique:users,email,' . $this->user->id,
                    'phone' => 'nullable',
                    'student_id' => 'nullable',
                    'designation' => 'nullable',
                    'calendar_id' => 'nullable',
                ];
                $nextStepOrRedirect = 'demographic_info';
                break;

            case 'demographic_info':
                $validationRules = [
                    'dob' => 'required|date',
                    'gender' => ['required', new EnumValue(Gender::class)],
                    'country_id' => 'required|exists:countries,id',
                    'city' => 'nullable',
                    'address' => 'nullable',
                    'ethnicity' => ['required', new EnumValue(Ethnicity::class)],
                    'uk_status' => ['nullable', new EnumValue(UKStatus::class)],
                ];
                $nextStepOrRedirect = $this->user->isStudent() ? 'nok_info' : '/profile';
                $this->user->update(['has_completed_profile' => true]);
                break;

            case 'nok_info':
                $validationRules = [
                    'nok_name' => 'required|max:100',
                    'nok_relation' => 'required|max:100',
                    'nok_email' => 'nullable|email',
                    'nok_phone' => 'required_if:nok_email,!=,null|max:100',
                ];
                $type = 'bio';
                $nextStepOrRedirect = 'career_info';
                break;

            case 'career_info':
                $validationRules = [
                    'qualification' => 'required',
                    'employment_status' => 'nullable',
                    'years_of_experience' => 'nullable',
                    'professional_registration_body' => 'nullable',
                    'how_did_you_hear_about_us' => 'nullable',
                    'att_level' => 'nullable',
                    'signed_doc' => 'nullable',
                ];
                $type = 'bio';
                $nextStepOrRedirect = '/profile';
                break;
        }

        $this->persistInfo($validationRules, $this->currentStep, $type, $nextStepOrRedirect);
    }

    private function persistInfo($validationRules, $currentStep, $type, $nextStepOrRedirect)
    {
        $validatedData = $this->validate($validationRules);

        // Save validated data to database
        switch ($type) {
            case 'bio':
                $this->user->bio()->update($validatedData);
                break;

            default:
                $this->user->update($validatedData);
                break;
        }

        if (is_string($nextStepOrRedirect) && strpos($nextStepOrRedirect, '_') !== false) {
            $this->previousStep = $currentStep;
            $this->currentStep = $nextStepOrRedirect;
        } else {
            return redirect()->intended($nextStepOrRedirect)->with('message', 'Profile Updated Successfully');
        }

    }

    public function render()
    {
        return view('livewire.backend.user-bio-data');
    }
}
