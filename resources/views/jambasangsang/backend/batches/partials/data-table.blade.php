@section('css')
  {{--  --}}
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Batch List')</strong>
                    <a
                        onclick="handleGeneralModal(this)"
                        data-link="{{ route('batches.create') }}"
                        type="button"
                        class="text-white pull-right btn btn-sm btn-success"
                    >@lang('New Batch')</a>
                </div>
                <div class="card-body">
                    <livewire:backend.batch-table />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
