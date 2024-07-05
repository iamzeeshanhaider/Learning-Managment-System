@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">

    @isset($folder)
        @php
            $routeParameters = ['lesson' => $lesson->slug, 'folder' => $folder->slug];
        @endphp
        <form
            action="{{ isset($resource) ? route('lesson.resource.update', $routeParameters + ['resource' => $resource->slug]) : route('lesson.resource.store', $routeParameters) }}"
            onsubmit="$('#resource-button').attr('disabled', true)" method="post" enctype="multipart/form-data">
            @if (isset($resource))
                @method('put')
            @endif
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name" class="mb-1 control-label">@lang('Resource Title')</label>
                        <input id="name" name="name" type="text" class="form-control name valid"
                            autocomplete="name" required value="{{ old('name', isset($resource) ? $resource->name : '') }}">
                        <span class="help-block field-validation-valid" data-valmsg-for="name"
                            data-valmsg-replace="true"></span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <x-select.lesson-resource-types label="Resource Type" :selected="isset($resource) ? $resource->type : ''" />
                    </div>
                    @error('type')
                        <div class="help-block field-validation-valid alert alert-danger">
                            {{ $message }}</div>
                    @enderror
                </div>

                <div id="file_container" class="m-0 p-0" data-type={{ isset($resource) ? $resource->type : null }}>
                    <div class="{{ isset($resource) ? 'col-md-8' : 'col-md-12' }}">
                        <div class="form-group">
                            <label for="file" class="mb-1 control-label">@lang('Resource File')</label>
                            <input id="file" name="file" type="file"
                                value="{{ isset($resource) ? $resource->file : old('file') }}"
                                accept=".mp4, .mov, .doc, .docx, .pdf, .ppt, .pptx, .jpg, .jpeg, .png"
                                class="form-control image @error('file') is-invalid @enderror">
                        </div>
                        @error('file')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}</div>
                        @enderror
                    </div>

                    @isset($resource)
                        <div class="col-md-4 form-group">
                            <label for="image" class="mb-1 control-label">@lang('Preview File')</label>
                            <a href="{{ $resource->file() }}" target="_blank" title="Preview File">
                                <i class="fa fa-{{ $resource->type_icon }} text-{{ $resource->type_color }} fa-4x"></i>
                            </a>
                        </div>
                    @endisset
                </div>

                <div class="col-md-12" id="url_container">
                    <div class="form-group">
                        <label for="url" class="mb-1 control-label">@lang('Resource Link')</label>
                        <input id="url" name="url" type="url" class="form-control name valid"
                            autocomplete="url" value="{{ old('url', isset($resource) ? $resource->url : '') }}">
                        <span class="help-block field-validation-valid" data-valmsg-for="url"
                            data-valmsg-replace="true"></span>
                    </div>
                </div>

                <div class="col-md-12" id="embed_container">
                    <div class="form-group">
                        <label for="embed_code" class="mb-1 control-label">@lang('Embed Content')</label>
                        <textarea name="embed_code" id="embed_code" rows="5" class="form-control" placeholder="Paste the embed script">{{ old('embed_code', isset($resource) ? $resource->embed_code : '') }}</textarea>
                        <span class="help-block field-validation-valid" data-valmsg-for="embed"
                            data-valmsg-replace="true"></span>
                    </div>
                </div>

            </div>

            <div>
                <button id="resource-button" type="submit" class="btn btn-lg btn-primary btn-block">
                    <span id="category-button-sending">
                        @isset($resource)
                            @lang('Update Lesson Resource')
                        @else
                            @lang('Create Resource')
                        @endisset
                    </span>&nbsp;
                    <i class="fa fa-arrow-right fa-lg"></i>
                </button>
            </div>
        </form>
    @else
        <form
            action="{{ route('lesson.resource.add_to_folder', ['lesson' => $lesson->slug, 'resource' => $resource->slug]) }}"
            onsubmit="$('#resource-button').attr('disabled', true)" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <x-select.folder-select label="Resource Folder" :lesson="$lesson" :selected="isset($resource) ? $resource->folder : null" />
                    </div>
                    @error('folder_id')
                        <div class="help-block field-validation-valid alert alert-danger">
                            {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <button id="resource-button" type="submit" class="btn btn-lg btn-primary btn-block">
                    @lang('Update Resource') &nbsp;
                    <i class="fa fa-arrow-right fa-lg"></i>
                </button>
            </div>
        </form>
    @endisset
</div>

<script>
    $('document').ready(function() {
        var file_container = $('#file_container');
        var url_container = $('#url_container');
        var embed_container = $('#embed_container');
        var resource_type = file_container.data('type');

        file_container.hide(200);
        url_container.hide(200);
        embed_container.hide(200);

        $("#resource_types").change(function() {
            var selected = $(this).val();
            $('#url').attr('required', selected === 'url');
            $('#file').attr('required', selected === 'file');
            $('#embed').attr('required', selected === 'embed');

            url_container.toggle(selected === 'url');
            file_container.toggle(selected === 'file');
            embed_container.toggle(selected === 'embed');
        });

        // Initially show the container based on the data-type attribute
        if (resource_type) {
            switch (resource_type) {
                case 'url':
                    url_container.show(200);
                    $('#url').required = true;
                    break;
                case 'file':
                    file_container.show(200);
                    $('#file').required = true;
                    break;
                case 'embed':
                    embed_container.show(200);
                    $('#embed').required = true;
                    break;
            }
        }
    });
</script>
