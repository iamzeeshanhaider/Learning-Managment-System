@section('css')
    {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">
                        @lang('Ticket Category List')
                    </strong>
                    <div class="pull-right">
                        <a onclick="handleGeneralModal(this)" data-link="{{ route('ticket_category.create') }}"
                            type="button" class="text-white btn btn-sm btn-success">@lang('New Category')</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:backend.support.ticket-category />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
