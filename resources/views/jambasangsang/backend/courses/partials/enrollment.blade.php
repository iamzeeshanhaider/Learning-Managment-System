<div>
    <form method="POST" action="{{ route('students.bulk_enrol') }}" onsubmit="$('.submit-btn').attr('disabled', true)">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <x-select.batch :selected="isset($batch) ? $batch->id : getActiveBatch()->id" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <x-select.course :selected="isset($course) && $course->id ? $course->id : $course" :readonly="isset($course) && $course->id ? true : false" :action="$action" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <x-select.users name="students[]" :selected="isset($student)
                        ? $student->id
                        : (isset($course)
                            ? $course->students->pluck('id')->toArray()
                            : [])"
                        allowMultiple="{{ isset($student) ? false : true }}"
                        readonly="{{ isset($student) ? true : false }}" />
                    @if (!$student)
                        <div class="d-flex justify-content-between align-items-center">
                            <small>Hold shift to seleft multiple students</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if ($action === 'enrol')
            @include('jambasangsang.backend.users.partials.student.payments.field', [($batchUser = null)])
        @endif

        <input class="form-check-input" type="hidden" name="action" id="enrolAction" value="{{ $action }}">

        @if ($action && $action !== 'enrol')
            <button type="submit" class="btn btn-lg btn-warning btn-block submit-btn">
                @lang('Confirm Action')&nbsp;<i class="fa fa-arrow-right fa-lg"></i>
            </button>
        @else
            <button type="submit" class="btn btn-lg btn-primary btn-block submit-btn">
                @lang('Save Changes')&nbsp;<i class="fa fa-arrow-right fa-lg"></i>
            </button>
        @endif
    </form>
</div>
