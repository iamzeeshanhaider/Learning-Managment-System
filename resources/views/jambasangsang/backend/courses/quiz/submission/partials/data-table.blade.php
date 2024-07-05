@section('css')
  {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-light border-bottom d-flex justify-content-between">
                    <strong class="card-title">@lang('Quiz Submissions')</strong>
                    <div class="p-2">
                        <x-batch-filter $filterByBatch="$filterByBatch" />
                    </div>
                </div>
                <div class="card-body">
                    <livewire:backend.submission-table quiz="{{ $quiz->id }}" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
