@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form action="{{ isset($module) ? route('modules.update', $module->slug) : route('modules.store') }}" method="post"
        enctype="multipart/form-data" onsubmit="$('#module-button').attr('disabled', true)">
        @if (isset($module))
            @method('put')
        @endif
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('Name')</label>
                    {{ old('name') }}
                    <input id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required value="{{ old('name', isset($module) ? $module->name : '') }}"
                        maxLength="150">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <x-editor id="module_description" value="{!! isset($module) ? $module->description : old('description') !!}" />
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <x-select.status :selected="isset($module) ? $module->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
                @error('status')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="{{ isset($module) ? 'col-3' : 'col-6' }}">
                <div class="form-group">
                    <label for="image" class="mb-1 control-label">@lang('Feature Image')</label>
                    <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg"
                        value="{{ isset($module) ? $module->image : old('image') }}"
                        class="form-control-file image @error('image') is-invalid @enderror" autocomplete="image">
                </div>
                @error('image')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            @isset($module)
                <div class="col-md-2 form-group">
                    <label for="image" class="mb-1 control-label">@lang('Preview Image')</label>
                    <img src="{{ $module->image() }}" alt="">
                </div>
            @endisset
        </div>

        <div>
            <button id="module-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="category-button-sending">
                    @isset($module)
                        @lang('Update Module')
                    @else
                        @lang('Create Module')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>
