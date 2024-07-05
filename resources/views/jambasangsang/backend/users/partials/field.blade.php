@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form
        action="{{ isset($user) ? route('users.update', ['group' => $group, 'user' => $user->slug]) : route('users.store', ['group' => $group]) }}"
        method="POST" enctype="multipart/form-data" onsubmit="$('#user-button').attr('disabled', true)">
        @csrf
        @if (isset($user))
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('First Name')</label>
                    <input style="text-transform: uppercase;" id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required value="{{ old('name', isset($user) ? $user->name : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div> {{-- First Name --}}

            <div class="col-md-6">
                <div class="form-group has-success">
                    <label for="lname" class="mb-1 control-label">@lang('Last Name')</label>
                    <input style="text-transform: uppercase;" id="lname" name="lname" type="text" class="form-control lname valid"
                        autocomplete="lname" required value="{{ old('lname', isset($user) ? $user->lname : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="lname"
                        data-valmsg-replace="true"></span>
                </div>
            </div> {{-- Last Name --}}

            <div class="col-md-6">
                <div class="form-group has-success">
                    <label for="email" class="mb-1 control-label">@lang('Email')</label>
                    <input id="email" name="email" type="email" class="form-control email valid"
                        autocomplete="email" required value="{{ old('email', isset($user) ? $user->email : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="email"
                        data-valmsg-replace="true"></span>
                </div>
            </div> {{-- Email --}}

            <div class="col-md-6">
                <div class="form-group has-success">
                    <label for="phone" class="mb-1 control-label">@lang('Phone')</label>
                    <input id="phone" name="phone" type="tel" placeholder="44774194712" class="form-control phone valid"
                        autocomplete="phone" value="{{ old('phone', isset($user) ? $user->phone : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="phone"
                        data-valmsg-replace="true"></span>
                </div>
            </div>
            {{-- Phone Number --}}

            @isset($user)
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <label for="username" class="mb-1 control-label">@lang('Username')</label>
                        <input id="username" name="username" type="text" class="form-control username valid"
                            autocomplete="username" value="{{ old('username', $user->username) }}">
                        <span class="help-block field-validation-valid" data-valmsg-for="username"
                            data-valmsg-replace="true"></span>
                    </div>
                </div> {{-- Username --}}

                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="mb-1 control-label">@lang('Password')
                            <small>(Leave blank if you do not intend to reset users password)</small>
                        </label>
                        <input id="password" name="password" type="password" class="form-control password valid"
                            autocomplete="user_updated_password" readonly>
                        <span class="help-block field-validation-valid" data-valmsg-for="password"
                            data-valmsg-replace="true"></span>
                    </div>
                </div> --}}
                {{-- Password --}}
            @endisset

            <div class="col-6">
                <div class="form-group">
                    <label for="dob" class="mb-1 control-label">@lang('Date of Birth')</label>
                    <input id="dob" name="dob" type="date"
                        value="{{ isset($user) && $user->dob ? $user->dob->format('Y-m-d') : old('dob') }}"
                        class="form-control dob @error('dob') is-invalid @enderror" autocomplete="start">
                </div>
                @error('dob')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div> {{-- Date of Birth --}}

            @if (in_array($group, ['admin', 'instructor']))
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <label for="designation" class="mb-1 control-label">@lang('Designation')</label>
                        <input id="designation" name="designation" type="text" class="form-control username valid"
                            autocomplete="designation"
                            value="{{ old('designation', isset($user) ? $user->designation : '') }}">
                        <span class="help-block field-validation-valid" data-valmsg-for="designation"
                            data-valmsg-replace="true"></span>
                    </div>
                </div> {{-- Designation --}}
            @endif

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.role :selected="isset($user) ? $user->getRoleNames()->first() : ''" :group="$group" />
                </div>
            </div> {{-- Role --}}

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.country :selected="isset($user) ? $user->country_id : ''" />
                </div> {{-- Country --}}
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="city" class="mb-1 control-label">@lang('City')</label>
                    <input id="city" name="city" type="text"
                        value="{{ isset($user) ? $user->city : old('city') }}"
                        class="form-control city @error('city') is-invalid @enderror" autocomplete="start">
                </div>
                @error('city')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror {{-- City --}}
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="address" class="mb-1 control-label">@lang('Address')</label>
                    <textarea name="address" class="form-control" id="address" rows="1">{{ isset($user) ? $user->address : old('address') }}</textarea>
                </div>
                @error('address')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div> {{-- Address --}}

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.gender :selected="isset($user) ? $user->gender : ''" />
                </div>
            </div> {{-- Gender --}}

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.status :selected="isset($user) ? $user->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
            </div> {{-- Status --}}

            <div class="{{ isset($user) ? 'col-md-4' : 'col-md-6' }}">
                <div class="form-group has-success">
                    <label for="status" class="mb-1 control-label">@lang('Image')</label>
                    <input type="file" name="image" id="image" class="form-control-file"
                        accept="image/png, image/gif, image/jpeg"
                        value="{{ isset($user) ? $user->image ?? '' : old('image') }}">
                </div>
            </div>

            @isset($user)
                <div class="col-md-2 form-group">
                    <label for="image" class="mb-1 control-label">@lang('Preview Image')</label>
                    <img src="{{ $user->image() }} " alt="">
                </div>
            @endisset

            <div class="col-md-12 {{ $group === 'student' ? 'd-none' : '' }}">
                <div class="form-group">
                    <x-select.permission :selected="isset($user) ? $user->getPermissionNames()->toArray() : []" :group="$group" />
                </div>
            </div> {{-- Permissions --}}

            <div class="col-md-12">
                <div class="form-group">
                    <label for="calendar_id" class="mb-1 control-label">@lang('Calendar ID')</label>
                    <input id="calendar_id" name="calendar_id" type="text"
                        value="{{ isset($user) ? $user->calendar_id : old('calendar_id') }}" placeholder="Enter Your Calendar ID"
                        class="form-control @error('calendar_id') is-invalid @enderror" autocomplete="calendar_id">
                </div>
                @error('calendar_id')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror {{-- calendar_id --}}
            </div>
        </div>

        <div class="d-flex">
            <button id="user-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="category-button-sending">
                    @isset($user)
                        @lang('Update User')
                    @else
                        @lang('Create User')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
    @isset($user)
        <form method="POST" class="text-right" action="{{ route('password.email') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}" />
            <button type="submit" class="btn btn-link">{{ __('Send Password Reset Link') }}</button>
        </form>
    @endisset
</div>
