@section('css')
  {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Locations List')</strong>
                    <a
                        onclick="handleGeneralModal(this)"
                        data-link="{{ route('locations.create') }}"
                        type="button"
                        class="text-white pull-right btn btn-sm btn-success"
                    >@lang('New Location')</a>
                </div>
                <div class="card-body">
                    <livewire:backend.location-table />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
