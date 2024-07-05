@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form
        action="{{ isset($courseMaster) ? route('courses_masters.update', $courseMaster->slug) : route('courses_masters.store') }}"
        method="POST" enctype="multipart/form-data" onsubmit="$('#courseMaster-button').attr('disabled', true)">
        @csrf
        @if (isset($courseMaster))
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('Name')</label>
                    {{ old('name') }}
                    <input id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required
                        value="{{ old('name', isset($courseMaster) ? $courseMaster->name : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <x-editor id="course_master_description" value="{!! isset($courseMaster) ? $courseMaster->description : old('description') !!}" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.categories :selected="isset($courseMaster)
                        ? $courseMaster->category_id
                        : (isset($category)
                            ? $category->id
                            : old('category_id'))" :readonly="isset($category) && $category->id ? true : false" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.status :selected="isset($courseMaster) ? $courseMaster->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
            </div>
        </div>
        <div>
            <button id="courseMaster-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="courseMaster-button-sending">
                    @isset($courseMaster)
                        @lang('Update Course Group')
                    @else
                        @lang('Create Course Group')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>
