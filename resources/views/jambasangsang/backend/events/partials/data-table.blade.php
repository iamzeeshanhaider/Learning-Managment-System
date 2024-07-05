@section('css')
  {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Events / News')</strong>
                    <a
                        onclick="handleGeneralModal(this)"
                        data-link="{{ route('events.create') }}"
                        type="button"
                        class="text-white pull-right btn btn-sm btn-success"
                    >@lang('New Event')</a>
                </div>
                <div class="card-body">
                    <livewire:backend.event-table />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
