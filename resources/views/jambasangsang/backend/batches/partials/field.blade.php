@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form
        action="{{ isset($batch) ? route('batches.update', $batch->slug) : route('batches.store') }}"
        method="POST" enctype="multipart/form-data"
        onsubmit="$('#batches-button').attr('disabled', true)"
        >
        @csrf
        @if (isset($batch))
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-success">
                    <label for="name" class="mb-1 control-label">@lang('Name')</label>
                    <input id="name" name="name" type="text" class="form-control name valid"
                        autocomplete="name" required
                        value="{{ old('name', isset($batch) ? $batch->name : '') }}"
                        maxlength="120"
                    >
                    <span class="help-block field-validation-valid" data-valmsg-for="name"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group has-success">
                    <x-editor
                        id="batch_description"
                        value="{!! isset($batch) ? $batch->description : old('description') !!}"
                    />
                </div>
            </div>
        </div>
        <div>
            <button id="batches-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="batch-button-sending">
                    @isset($batch)
                    @lang('Update Batch')
                    @else
                    @lang('Create Batch')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>

