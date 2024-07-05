@section('css')
    {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">
                        @if (isset($category))
                            @lang('Course Group For Categroy:') {{ ucwords($category->name) }}
                        @else
                            @lang('Course Group List')
                        @endif
                    </strong>
                    <div class="pull-right">
                        @isset($category)
                            <a href="{{ route('courses_masters.index') }}" class="mx-2 btn btn-sm btn-primary"> <small><i
                                        class="fa fa-filter"></i> Clear Filter</small></a>
                        @endisset
                        <a onclick="handleGeneralModal(this)"
                            data-link="{{ route('courses_masters.create', isset($category) ? ['category' => $category->slug] : '') }}"
                            type="button" class="text-white btn btn-sm btn-success">@lang('New Course Group')</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:backend.course-master-table
                        category="{{ isset($category) ? $category->id : $category }}" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
