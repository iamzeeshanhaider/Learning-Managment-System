<div>
    <form method="POST" action="{{ route('student.payment.update', $batchUser->payment_id) }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="batch" class="mb-1 control-label">@lang('Batch')</label>
                    <input id="batch" name="batch" type="text" value="{{ $batchUser->batch->name ?? '' }}"
                        maxlength="120" class="form-control" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="course" class="mb-1 control-label">@lang('Course')</label>
                    <input id="course" name="course" type="text" value="{{ $batchUser->course->title ?? '' }}"
                        maxlength="120" class="form-control" readonly>
                </div>
            </div>
        </div>

        @include('jambasangsang.backend.users.partials.student.payments.field', $batchUser)

        <button type="submit" class="btn btn-lg btn-primary btn-block">
            @lang('Save Changes')&nbsp;<i class="fa fa-arrow-right fa-lg"></i>
        </button>
    </form>
</div>
