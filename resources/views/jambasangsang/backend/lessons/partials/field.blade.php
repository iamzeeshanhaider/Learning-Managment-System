@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form action="{{ isset($lesson) ? route('lessons.update', $lesson->slug) : route('lessons.store') }}" method="post"
        enctype="multipart/form-data" onsubmit="$('#lessons-button').attr('disabled', true)">
        @if (isset($lesson))
            @method('put')
        @endif
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('Name')</label>
                    {{ old('name') }}
                    <input id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required value="{{ old('name', isset($lesson) ? $lesson->name : '') }}"
                        maxlength="120">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <x-editor id="lesson_outcome" label="Outcome" fieldName="outcome"
                        placeholder="A brief learning outcome" value="{!! isset($lesson) ? $lesson->outcome : old('outcome') !!}" :required="true" />
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <x-select.course :selected="isset($lesson) ? $lesson->course_id : (isset($course) ? $course->id : old('course_id'))" :readonly="isset($course) && $course->id ? true : false" />
                </div>
                @error('course_id')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <x-select.status :selected="isset($lesson) ? $lesson->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
                @error('status')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="{{ isset($lesson) ? 'col-3' : 'col-6' }}">
                <div class="form-group">
                    <label for="image" class="mb-1 control-label">@lang('Image')</label>
                    <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg"
                        value="{{ isset($lesson) ? $lesson->image : old('image') }}"
                        class="form-control-file image @error('image') is-invalid @enderror" autocomplete="image">
                </div>
                @error('image')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            @isset($lesson)
                <div class="col-md-3 form-group">
                    <label for="image" class="mb-1 control-label">@lang('Preview Image')</label>
                    <img src="{{ $lesson->image() }}" alt="">
                </div>
            @endisset
        </div>

        <div>
            <button id="lessons-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="category-button-sending">
                    @isset($lesson)
                        @lang('Update Lesson')
                    @else
                        @lang('Create Lesson')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>
