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
                    <strong class="card-title">@lang('Option List')</strong>
                    <a href="{{ route('chat_options.create', $chatQuestion) }}"
                        class="pull-right btn btn-sm btn-success">@lang('New option')</a>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('ID')</th>
                                <th>@lang('Option')</th>
                                <th>@lang('Slug')</th>
                                <th>@lang('Status')</th>
                                @can('delete_layers' || 'edit_layers')
                                    <th>@lang('Action')</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($options as $option)
                                <tr>
                                    <td>
                                        {{ $option->id }}
                                    </td>
                                    <td><a href="{{ $option->link() }}">{{ $option->option }}</a> </td>
                                    <td>{{ $option->slug }}</td>
                                    <td>{{ $option->status }}</td>
                                    @can('delete_layers' || 'edit_layers')
                                        <td>
                                            <div class="btn-group">
                                                @can('edit_layers')
                                                    <a href="{{ route('chat_options.edit', [$option]) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                @endcan

                                                @can('delete_layers')
                                                    <a href="" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash"></i></a>
                                                @endcan

                                            </div>
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
