@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form
        action="{{ $action === 'unenroll' ? route('student.enroll', ['student' => $student, 'action' => 'unenroll']) : route('student.enroll', ['student' => $student, 'action' => 'enroll']) }}"
        method="POST" enctype="multipart/form-data">
        @csrf

        @switch($action)
            @case('enroll')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <x-select.batch selected="" />
                        </div>
                        @error('batch_id')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <x-select.course selected="" />
                        </div>
                        @error('course_id')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button id="enroll-button" type="submit" class="btn btn-lg btn-primary btn-block">
                    <span id="enroll-button-sending">
                        @lang('Enroll')
                    </span>&nbsp;
                    <i class="fa fa-arrow-right fa-lg"></i>
                </button>
            @break

            @case('unenroll')

                <div class="text-center">
                    <div class="icon-box">
                        <i class="fa fa-times"></i>
                    </div>

                    <input type="hidden" name="batch_id" value="{{ $meta_data['batch_id'] }}">
                    <input type="hidden" name="course_id" value="{{ $meta_data['course_id'] }}">

                    <h5 class="py-2">Confirm you want to the student from this course</h5>
                    <p>This student will no longer have access to this course and it's lessons / resources!</p>
                    <div>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger">Yes, Proceed</button>
                    </div>
                </div>
            @break

        @endswitch
    </form>
</div>
