@section('css')
  {{--  --}}
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">@lang('Chat Request List')</strong>
                </div>
                <div class="card-body">
                    <livewire:backend.chat-requests-table userID="all" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
