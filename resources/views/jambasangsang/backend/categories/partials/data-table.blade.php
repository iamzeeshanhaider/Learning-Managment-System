@section('css')
  {{--  --}}
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Category List')</strong>
                    <a
                        onclick="handleGeneralModal(this)"
                        data-link="{{ route('categories.create') }}"
                        type="button"
                        class="text-white pull-right btn btn-sm btn-success"
                    >@lang('New Category')</a>
                </div>
                <div class="card-body">
                    <livewire:backend.category-table />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
