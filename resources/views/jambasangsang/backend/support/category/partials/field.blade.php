@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form
        action="{{ isset($ticket_category) ? route('ticket_category.update', $ticket_category) : route('ticket_category.store') }}"
        method="post" novalidate="novalidate" enctype="multipart/form-data">
        
        @csrf
        @isset($ticket_category)
            @method('put')
        @endisset

        <div class="row">
            <div class="col-12">
                <div class="form-group has-success">
                    <label for="name" class="control-label mb-1">@lang('Title')</label>
                    <input id="name" name="name" type="text" class="form-control title valid"
                        value="{{ $ticket_category->name ?? old('name') }}">
                </div>

                @error('name')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <x-select.status :selected="isset($ticket_category) ? $ticket_category->status : \App\Enums\GeneralStatus::Enabled" />
            </div>
        </div>

        <div>
            <button id="category-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <i class="fa fa-save fa-lg"></i>&nbsp;
                <span>{{ isset($ticket_category) ? __('Update') : __('Create') }}</span>
            </button>
        </div>
    </form>
</div>
