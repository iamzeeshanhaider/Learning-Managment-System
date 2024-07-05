<div class="animated fadeIn">
    <div class="row">
        <div class="py-2 m-auto col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Credit Card -->
                    <div id="pay-invoice">
                        <div class="card-body">
                            <form
                                action="{{ isset($chat_option) ? route('chat_options.update', $chat_option->id) : route('chat_options.store') }}"
                                method="post" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                @isset($chat_option)
                                    @method('put')
                                @endisset

                                {{-- <input id="chat_layer_id" name="chat_layer_id" type="hidden" value="{{ isset($chat_option) ? $chat_option->chat_layer_id : $chatLayer }}"> --}}

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group has-success">
                                            <label for="option" class="mb-1 control-label">@lang('Option')</label>
                                            <input id="option" name="option" type="text"
                                                class="form-control title valid"
                                                value="{{ isset($chat_option) ? $chat_option->option : old('option') }}">
                                        </div>
                                        @error('option')
                                            <div class="help-block field-validation-valid alert alert-danger">
                                                {{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-4 row">

                                    <div class="mt-3 col-3">
                                        <div class="form-group">
                                            <x-select.status :selected="isset($chat_option) ? $chat_option->status : old('status')" />
                                        </div>
                                        @error('status')
                                            <div class="help-block field-validation-valid alert alert-danger">
                                                {{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-primary btn-block">
                                        <i class="fa fa-save fa-lg"></i>&nbsp;
                                        <span id="payment-button-amount">@lang('Create Question')</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div> <!-- .card -->

        </div>
        <!--/.col-->
    </div>
</div><!-- .animated -->


@section('script')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('lessons.image-upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
