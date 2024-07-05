@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form action="{{ isset($category) ? route('categories.update', $category->slug) : route('categories.store') }}"
        method="POST" enctype="multipart/form-data"
        onsubmit="$('#category-button').attr('disabled', true)"
        >
        @csrf
        @if (isset($category))
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('Name')</label>
                    <input id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required value="{{ old('name', isset($category) ? $category->name : '') }}" maxLength="150">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
                @error('name')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <x-editor id="category_description" value="{!! isset($category) ? $category->description : old('description') !!}" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.status
                        :selected="isset($category) ? $category->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
            </div>

            <div class="{{ isset($category) ? 'col-md-4' : 'col-md-6' }}">
                <div class="form-group has-success">
                    <label for="status" class="mb-1 control-label">@lang('Featured Image')</label>
                    <input type="file" name="image" id="image" class="form-control-file"
                        accept="image/png, image/gif, image/jpeg"
                        value="{{ isset($category) ? $category->image ?? '' : old('image') }}">
                </div>
            </div>

            @isset($category)
                <div class="col-md-2 form-group">
                    <label for="image" class="mb-1 control-label">@lang('Preview Image')</label>
                    <img src="{{ $category->image() }} " alt="">
                </div>
            @endisset
        </div>
        <div>
            <button id="category-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="category-button-sending">
                    @isset($category)
                        @lang('Update Category')
                    @else
                        @lang('Create Category')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>
