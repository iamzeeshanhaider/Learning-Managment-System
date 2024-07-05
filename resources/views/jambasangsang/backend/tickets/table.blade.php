@section('css')
    <link rel="stylesheet"
        href="{{ asset('jambasangsang/backend/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('jambasangsang/backend/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
@endsection

<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">@lang('Support Ticket List')</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Instructor')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Last Updated')</th>
                                <th>@lang('Priority')</th>
                                {{-- @can('delete_courses' || 'edit_courses' || 'add_lessons') --}}
                                <th>@lang('Action')</th>
                                {{-- @endcan --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td> <a href="{{ url('tickets/' . $ticket->ticket_id) }}">
                                            #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                        </a></a>
                                    </td>
                                    <td> {{ $ticket->category->name }}</td>
                                    <td> {{ $ticket->instructor->name ?? 'Not assign' }}</td>
                                    <td>
                                        @if ($ticket->status === 'Open')
                                            <span class="label label-success">{{ $ticket->status }}</span>
                                        @else
                                            <span class="label label-danger">{{ $ticket->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->updated_at }}</td>
                                    <td>{{ $ticket->priority }}</td>
                                    @can('delete_courses' || 'edit_courses' || 'add_lessons')
                                        <td>
                                            <div class="d-flex flex-row">
                                                <a href="{{ url('edit_ticket/' . $ticket->ticket_id) }}"
                                                    class="btn btn-warning text-light"><i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                @if ($ticket->status === 'open')
                                                    <a href="{{ url('tickets/' . $ticket->ticket_id) }}"
                                                        class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>

                                                    <form action="{{ url('close_ticket/' . $ticket->ticket_id) }}"
                                                        method="POST">
                                                        {!! csrf_field() !!}
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                            </form>
                                        </div>
                                @endif
                                </td>
                            @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div><!-- .animated -->

@section('script')
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}">
    </script>
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('jambasangsang/backend/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/assets/js/init-scripts/data-table/datatables-init.js') }}"></script>

@endsection
