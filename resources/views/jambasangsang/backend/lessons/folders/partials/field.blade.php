@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form
        action="{{ isset($folder) ? route('lesson.folder.update', ['lesson' => $lesson->slug, 'folder' => $folder]) : route('lesson.folder.store', ['lesson' => $lesson->slug]) }}"
        onsubmit="$('#folder-button').attr('disabled', true)" method="POST">
        @if (isset($folder))
            @method('put')
        @endif
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="mb-1 control-label">@lang('Folder Name')</label>
                    <input id="name" name="name" type="text" class="form-control" autocomplete="folder_name"
                        required value="{{ old('name', isset($folder) ? $folder->name : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" {{ isset($folder) && $folder->is_published ? 'checked' : '' }} name="is_published" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Publish Folder
                    </label>
                </div>
            </div>
        </div>

        <div>
            <button id="folder-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="category-button-sending">
                    {{ isset($folder) ? __('Update') : __('Create') }} Folder
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>
