<div class="animated fadeIn">
    <div class="row">
        <div class="py-2 m-auto col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Credit Card -->
                    <div id="pay-invoice">
                        <div class="card-body">
                            <form
                                action="{{ isset($chatLayer) ? route('chat_layers.update', $chatLayer->id) : route('chat_layers.store') }}"
                                method="post" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                @isset($chatLayer)
                                    @method('put')
                                @endisset
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group has-success">
                                            <label for="name" class="mb-1 control-label">@lang('Title')</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control title valid"
                                                value="{{ isset($chatLayer) ? $chatLayer->name : old('name') }}">
                                        </div>
                                        @error('name')
                                            <div class="help-block field-validation-valid alert alert-danger">
                                                {{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-4 row">

                                    <div class="mt-3 col-3">
                                        <div class="form-group">
                                            <x-select.status :selected="isset($chatLayer) ? $chatLayer->status : old('status')" />
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
                                        <span id="payment-button-amount">@lang('Create Layer')</span>
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
