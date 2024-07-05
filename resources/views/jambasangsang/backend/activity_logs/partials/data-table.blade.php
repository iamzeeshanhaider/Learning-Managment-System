@section('css')
    {{--  --}}
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Activity Logs List')</strong>
                </div>
                <div class="card-body">
                    <livewire:backend.activity-logs-table userID="all" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
