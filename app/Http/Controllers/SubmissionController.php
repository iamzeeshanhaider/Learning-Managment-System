<?php

namespace App\Http\Controllers;

use App\Enums\QuizTypes;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\BatchUser;
use App\Models\Quiz;
use App\Models\Submission;
use App\Notifications\SubmissionGraded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quiz $quiz)
    {
        $filterByBatch = $request->has('batch_filter');

        return view('jambasangsang.backend.courses.quiz.submission.index', compact('quiz', 'filterByBatch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubmissionRequest  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubmissionRequest $request, Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $file = null;

            if($request->hasFile('file')) {
                $file = uploadOrUpdateFile($request->file('file'), $request, \constPath::SubmissionFile);
            }

            $batch_user = BatchUser::findOrFail($request->get('batch_user_id'));

            $submission = Submission::create([
                'quiz_id' => $quiz->id,
                'student_id' => auth()->user()->id,
                'course_id' => $batch_user->course_id,
                'batch_id' => $batch_user->batch_id,
                'file' => $file,
                'value' => $request->get('value'),
            ]);

            $submitted_quiz = is_array($batch_user->submitted_quiz) ? $batch_user->submitted_quiz : [];
            array_push($submitted_quiz, $submission->id);

            $batch_user->update([
                'submitted_quiz' => $submitted_quiz
            ]);

            DB::commit();

            LaravelFlash::withSuccess('Operation Successful');
            return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollBack();
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz $quiz
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz, Submission $submission)
    {
        $variables = collect([
            'type' => 'submission',
            'title' => 'quiz',
            'size' => 'xl',
            'file' => 'backend.lessons.quiz.submission.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'quiz', 'submission'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubmissionRequest  $request
     * @param  \App\Models\Quiz $quiz
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubmissionRequest $request, Quiz $quiz, Submission $submission)
    {
        try {
            DB::beginTransaction();

            $submission->update($request->validated());

            // notify student
            if($request->get('notify_student')) {
                $submission->student->notify(new SubmissionGraded([
                    'lname' => $submission->student->lname,
                    'course_title' => $quiz->lesson->course->title,
                    'lesson_title' => $quiz->lesson->name,
                    'quiz_start_time' => $quiz->start_time,
                    'quiz_end_time' => $quiz->end_time,
                    'submission_date' => $quiz->created_at,
                    'submission_url' => route('student.courses.show', ['batch' => $submission->batch_id, 'course' => $submission->course_id, 'l_view' => $quiz->lesson->slug]),
                ]));
            }

            DB::commit();

            LaravelFlash::withSuccess('Submission Graded Successfully');
            return redirect()->back();
        } catch(\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }
}
