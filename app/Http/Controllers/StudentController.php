<?php

namespace App\Http\Controllers;

use App\Enums\GeneralStatus;
use App\Http\Requests\StoreBatchEnrol;
use App\Models\{Batch, BatchUser, Course, Payment, User};
use App\Notifications\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class StudentController extends Controller
{
    /**
     * Display form to enroll student
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $request
     * @param $action
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $student, $action)
    {
        $meta_data = $request->get('course_user');

        $variables = collect([
            'type' => 'student',
            'title' => $action === 'enroll' ? 'Enroll' : 'Un-Enroll',
            'size' => $action === 'enroll' ? 'lg' : 'md',
            'file' => 'backend.users.partials.student.enroll-unenroll'
        ]);

        return view('components.partials.general-modal', compact('variables', 'student', 'action', 'meta_data'))->render();
    }

    /**
     * Display Payment Log for student
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BatchUser $payment_log
     * @param $action
     * @return \Illuminate\Http\Response
     */
    public function show_payment_log(Request $request, BatchUser $payment_log)
    {
        $payment_log->loadMissing([
            'batch',
            'payment' => fn ($q) => $q->with('children'),
            'course' => fn ($q) => $q->with('course_master'),
        ]);

        $variables = collect([
            'type' => 'student',
            'title' => 'Payment Logs for',
            'size' => 'xl',
            'file' => 'backend.users.partials.student.payments.logs'
        ]);

        return view('components.partials.general-modal', compact('variables', 'payment_log'))->render();
    }


    /**
     * Display form to enroll student
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function init_handle_enrolment(Request $request)
    {
        $course = $request->get('course') ? Course::where('slug', $request->get('course'))->first() : null;
        $student = $request->get('student') ? User::where('slug', $request->get('student'))->first() : null;
        $action = $request->get('action') ?? 'enrol';

        $variables = collect([
            'type' => 'student',
            'title' => 'Bulk Enrol Students',
            'size' => 'lg',
            'file' => 'backend.courses.partials.enrollment'
        ]);

        return view('components.partials.general-modal', compact('variables', 'course', 'student', 'action'))->render();
    }

    /**
     * Handle student enroll and unenroll
     *
     * @param \App\Http\Requests\StoreBatchEnrol $request
     * @return \Illuminate\Http\Response
     */
    public function handle_enrolment(StoreBatchEnrol $request)
    {
        $action = $request->get('action');
        $batch = Batch::findOrFail($request->get('batch_id'));
        $course = Course::findOrFail($request->get('course_id'));
        $students = User::role('student')->whereIn('id', $request->get('students'))->get();

        try {

            if ($students) {
                // Enroll Students
                foreach ($students as $student) {
                    // get id of all students that are already enrolled
                    $oldStudents = $course->students->pluck('id')->toArray();

                    // check if user is enrolled already
                    $isEnrolled = $student->courses()->where('course_id', $course->id)->where('batch_id', $batch->id)->exists();

                    // if user is enrolled and is not part of the new list, unenroll else enroll
                    if ($isEnrolled && in_array($student->id, $oldStudents) && $action === 'unenrol') {
                        $res = static::unenrol($student, $course, $batch);
                    } else if (!$isEnrolled && $action === 'enrol') {
                        $res = static::enrol($request, $student, $course, $batch);
                    } else {
                        LaravelFlash::withInfo('Student is already Enrolled for this course/batch');
                        return redirect()->back();
                    }
                }

                if($res) {
                    if($res['success']) {
                        LaravelFlash::withSuccess($res['message']);
                    } else {
                        LaravelFlash::withError($res['message']);
                    }
                    return redirect()->back();
                }

                return $student;

            } else {
                LaravelFlash::withInfo('What are you trying to do?');
            }
            return redirect()->back();

        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Handle student enrolment
     *
     * @param \App\Http\Requests\StoreBatchEnrol $request
     * @param \App\Models\User $student
     * @param \App\Models\Course $course
     * @param \App\Models\Batch $batch
     * @return \Illuminate\Http\Response
     */
    public static function enrol(StoreBatchEnrol $request, User $student, Course $course, Batch $batch)
    {
        try {
            DB::beginTransaction();

            // save payment information
            $payment = Payment::create([
                'student_id' => $student->id,
                'amount_paid' => $request->get('amount_paid'),
                'invoice_id' => $request->get('invoice_id'),
                'payment_mode' => $request->get('payment_mode'),
                'proof_of_payment' => $request->get('proof_of_payment'), // Upload is handled with observer
            ]);

            // Save student enrollment information
            $student->courses()->attach($course->id, [
                'batch_id' => $batch->id,
                'payment_id' => $payment->id,
                'fee' => $request->get('fee') ?? 0,
                'discount' => $request->get('discount') ?? 0,
                'fee_after_discount' => $request->get('fee_after_discount') ?? 0,
                'next_payment_due_date' => $request->get('next_payment_due_date'),
            ]);

            // Notify the student of new enrollment
            // TODO: notify student
            $student->notify(new CourseEnrollment([
                'lname' => $student->lname,
                'email' => $student->email,
                'course_title' => $course->title,
                'course_code' => $course->code,
                'course_url' => route('student.courses.show', ['batch' => $batch->id, 'course' => $course->id]),
            ]));

            DB::commit();

            $res = [
                'success' => true,
                'message' => 'Student(s) Enrolled Successfully',
            ];

            return $res;
        } catch (\Throwable $th) {
            DB::rollBack();
            $res = [
                'success' => false,
                'message' => $th->getMessage(),
            ];
            return $res;
        }
    }

    /**
     * Handle student unenrolment
     *
     * @param \App\Models\User $student
     * @param \App\Models\Course $course
     * @param \App\Models\Batch $batch
     * @return \Illuminate\Http\Response
     */
    public static function unenrol(User $student, Course $course, Batch $batch)
    {
        try {
            DB::beginTransaction();

            // Disable payment status
            $student->payments()->where(['course_id' => $course->id, 'batch_id' => $batch->id])->update(['status' => GeneralStatus::Disabled]);

            // unenrol student from course & batch
            $student->courses()->detach($course->id, ['batch_id' => $batch->id]);

            DB::commit();

            $res = [
                'success' => true,
                'message' => 'Student Un-Enrolled Successfully',
            ];
            return $res;
        } catch (\Throwable $th) {
            DB::rollBack();
            $res = [
                'success' => false,
                'message' => $th->getMessage(),
            ];
            return $res;
        }
    }

    /**
     * Display form to update student payment
     *
     * @param \App\Models\BatchUser $batchUser
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function init_update_payment(BatchUser $batchUser)
    {
        $variables = collect([
            'type' => 'student',
            'title' => 'Update Payment for ',
            'size' => 'lg',
            'file' => 'backend.users.partials.student.payments.update'
        ]);

        return view('components.partials.general-modal', compact('variables', 'batchUser'))->render();
    }

    /**
     * Handle student enrolment
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @param \App\Models\User $student
     * @return \Illuminate\Http\Response
     */
    public function update_payment(Request $request, Payment $payment)
    {
        try {
            DB::beginTransaction();

            // save payment information
            $payment = Payment::create([
                'student_id' => $payment->student_id,
                'parent_id' => $payment->id,
                'amount_paid' => $request->get('amount_paid'),
                'invoice_id' => $request->get('invoice_id'),
                'payment_mode' => $request->get('payment_mode'),
                'proof_of_payment' => $request->get('proof_of_payment'), // Upload is handled with observer
            ]);

            DB::commit();
            LaravelFlash::withSuccess('Student Payment Updated Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }
}
