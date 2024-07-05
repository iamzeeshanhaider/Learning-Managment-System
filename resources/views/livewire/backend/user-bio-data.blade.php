<div>
    <div class="card p-3 border-0 rounded shadow-lg">
        <form wire:submit.prevent="goToNextStep">
            <div class="" style="min-height: 500px">
                @switch($currentStep)
                    @case('personal_info')
                        {{-- Personal Info --}}
                        <div class="card-header bg-light border-bottom h4">@lang('Personal Information')</div>

                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="firstName">@lang('First Name'):</label>
                                    <input class="form-control" id="firstName" type="text" wire:model.lazy="name"
                                        placeholder="Enter Your First Name">
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="lastName">@lang('Last Name'):</label>
                                    <input class="form-control" id="lastName" type="text" wire:model.lazy="lname"
                                        placeholder="Enter Your Last Name">
                                    @error('lname')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="email">@lang('Email'):</label>
                                    <input class="form-control" id="email" type="email" readonly
                                        wire:model.lazy="email">
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if ($user->isStudent())
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-1" for="student_id">@lang('Student ID'):</label>
                                        <input class="form-control" id="text" type="student_id" readonly
                                            wire:model.lazy="student_id">
                                        @error('student_id')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-1" for="designation">@lang('Designation'):</label>
                                        <input class="form-control" id="text" type="designation" readonly
                                            wire:model.lazy="designation">
                                        @error('designation')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="username">@lang('Username'):</label>
                                    <input class="form-control" id="username" type="text" wire:model.lazy="username"
                                        placeholder="Enter Your Username">
                                    @error('username')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="phone">@lang('Phone Number'):</label>
                                    <input class="form-control" id="phone" type="tel" wire:model.lazy="phone"
                                        placeholder="+44 201 23 4567">
                                    @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if (!$user->isStudent())
                            <div class="card-header bg-light border-bottom h4">@lang('Additional Information')</div>

                            <div class="row p-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-1" for="calendar_id">@lang('Calendar ID'):</label>
                                        <input class="form-control" id="calendar_id" type="text" wire:model.lazy="calendar_id"
                                            placeholder="Enter Your Calendar ID">
                                        @error('calendar_id')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    @break

                    @case('demographic_info')
                        {{-- Demographic Info --}}

                        <div class="card-header bg-light border-bottom h4">@lang('Demographic Information')</div>

                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="dob">@lang('Date of Birth'):</label>
                                    <input class="form-control" id="dob" type="date" wire:model.lazy="dob">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-select.gender :selected="$gender" :isWire="true" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <x-select.country :selected="$country_id" :isWire="true" />
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="city">@lang('City'):</label>
                                    <input class="form-control" id="city" type="text" wire:model.lazy="city"
                                        placeholder="London">
                                    @error('city')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-1" for="city">@lang('Address'):</label>
                                    <textarea wire:model.lazy="address" class="form-control" id="address" rows="4"></textarea>
                                    @error('address')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-select.ethnicity :selected="$ethnicity" :isWire="true" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="uk_status">@lang('Status in UK'):</label>
                                    <select required id="uk_status" class="form-control" wire:model.lazy="uk_status">
                                        <option value="" selected>@lang('--Select Status--')</option>
                                        @foreach (\App\Enums\UKStatus::getInstances() as $status)
                                            <option value="{{ $status }}" {{ is_selected($status, $uk_status) }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('uk_status')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    @break

                    @case('nok_info')
                        {{-- Carret Info --}}
                        <div class="card-header bg-light border-bottom h4">@lang('Next of Kin Information')</div>

                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="nok_name">@lang('NOK Name'):</label>
                                    <input class="form-control" id="nok_name" type="text" wire:model.lazy="nok_name"
                                        placeholder="Enter Full Name">
                                    @error('nok_name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="nok_email">@lang('NOK Email'):</label>
                                    <input class="form-control" id="nok_email" type="email" wire:model.lazy="nok_email"
                                        placeholder="email@domain.com">
                                    @error('nok_email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="nok_phone">@lang('NOK Phone Number'):</label>
                                    <input class="form-control" id="nok_phone" type="tel" wire:model.lazy="nok_phone"
                                        placeholder="+44 201 23 4567">
                                    @error('nok_phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="nok_relation">@lang('Relationship With NOK'):</label>
                                    <input class="form-control" id="nok_relation" type="text"
                                        wire:model.lazy="nok_relation" placeholder="Sibling">
                                    @error('nok_relation')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    @break

                    @case('career_info')
                        {{-- Carret Info --}}
                        <div class="card-header bg-light border-bottom h4">Career Information</div>

                        <div class="row p-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="qualification">@lang('Qualification'):</label>
                                    <select required id="qualification" class="form-control" wire:model.lazy="qualification">
                                        <option value="" selected>@lang('--Select Qualification--')</option>
                                        @foreach (['GCSE', 'A Level', 'Level 2', 'Level 3', 'Level 4', 'Bachelors', 'Masters', 'Professional Qualification', 'Others'] as $value)
                                            <option value="{{ $value }}" {{ is_selected($value, $qualification) }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('qualification')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="employment_status">@lang('Employment Status'):</label>
                                    <select required id="employment_status" class="form-control"
                                        wire:model.lazy="employment_status">
                                        <option value="" selected>@lang('--Select Employment Status--')</option>
                                        @foreach (['Employed - Full Time', 'Employed - Part Time', 'Career Break', 'Seeking Employment'] as $value)
                                            <option value="{{ $value }}"
                                                {{ is_selected($value, $employment_status) }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employment_status')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="years_of_experience">@lang('Years of Experience'):</label>
                                    <select required id="years_of_experience" class="form-control"
                                        wire:model.lazy="years_of_experience">
                                        <option value="" selected>@lang('--Select Years of Experience--')</option>
                                        @foreach (['Less than 6 Months', '1 - 3 Years', '4 - 6', '7 Years Plus'] as $value)
                                            <option value="{{ $value }}"
                                                {{ is_selected($value, $years_of_experience) }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('years_of_experience')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="professional_registration_body">@lang('Professional Body'):</label>
                                    <select required id="professional_registration_body" class="form-control"
                                        wire:model.lazy="professional_registration_body">
                                        <option value="" selected>@lang('--Select Professional Body--')</option>
                                        @foreach (['AAT', 'ACCA', 'ICAEW', 'IFA', 'IAB', 'ICB', 'Others'] as $value)
                                            <option value="{{ $value }}"
                                                {{ is_selected($value, $professional_registration_body) }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('professional_registration_body')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1" for="how_did_you_hear_about_us">@lang('How did you hear about us'):</label>
                                    <select required id="how_did_you_hear_about_us" class="form-control"
                                        wire:model.lazy="how_did_you_hear_about_us">
                                        <option value="" selected>@lang('--Select Source--')</option>
                                        @foreach (['Website', 'Reed', 'Online Campaign', 'Gumtree', 'Referral', 'Email', 'Marketing Campaign - Mall', 'Other'] as $value)
                                            <option value="{{ $value }}"
                                                {{ is_selected($value, $how_did_you_hear_about_us) }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('how_did_you_hear_about_us')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                           {{-- <div class="col-md-6">
                                <div class="form-group">
                                    --}}{{--<label class="mb-1" for="att_level">@lang('ATT Level'):</label>--}}{{--
                                    <select required id="att_level" class="form-control" wire:model.lazy="att_level">
                                        <option value="" selected>@lang('--Select ATT Level--')</option>
                                        @foreach (['One', 'Two', 'Other'] as $value)
                                            <option value="{{ $value }}" {{ is_selected($value, $att_level) }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('att_level')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>--}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="signed_doc">Document Signed?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model.lazy="signed_doc"
                                            id="signed_doc_yes" value="1">
                                        <label class="form-check-label" for="signed_doc_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model.lazy="signed_doc"
                                            id="signed_doc_no" value="0" checked>
                                        <label class="form-check-label" for="signed_doc_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @break

                @endswitch
            </div>

            {{-- Buttons --}}
            <div class="btn-group px-2" role="group" aria-label="Basic example">
                @if ($previousStep)
                    <a type="button" class="btn btn-primary text-white" {{ $disabled ? 'disabled' : '' }}
                        wire:click="goToPreviousStep">Previous</a>
                @endif
                <button type="submit" class="btn btn-primary"
                    {{ $disabled ? 'disabled' : '' }}>{{ $user->isAdmin() && $currentStep === 'demographic_info' ? 'Save' : ($currentStep === 'career_info' ? 'Save' : 'Next') }}</button>
            </div>
            {{-- Buttons --}}
        </form>
    </div>
</div>
