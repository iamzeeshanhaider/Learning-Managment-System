<?php

namespace App\Http\Controllers;

use App\Enums\GeneralStatus;
use App\Models\{BatchUser, Course, Question, QuestionOption, Quiz};
use Illuminate\Http\Request;
use Jambasangsang\Flash\Facades\LaravelFlash;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterByBatch = $request->has('batch_filter');
        $course = $request->has('course') ? Course::firstWhere(['slug' => $request->get('course')]) : null;

        return view('jambasangsang.backend.courses.quiz.index', compact('course', 'filterByBatch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course = $request->has('course') ? Course::firstWhere(['slug' => $request->get('course')]) : null;
        $quiz = null;

        return view('jambasangsang.backend.courses.quiz.create', compact('course', 'quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $variables = collect([
            'type' => 'quiz',
            'title' => 'Preview',
            'size' => 'xl',
            'file' => 'backend.courses.quiz.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'quiz'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Quiz $quiz)
    {
        $course = $request->has('course') ? Course::firstWhere(['slug' => $request->get('course')]) : null;

        return view('jambasangsang.backend.courses.quiz.create', compact('course', 'quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Quiz  $originalQuiz
     * @return \Illuminate\Http\Response
     */
    public function clone(Request $request, Quiz $quiz)
    {
        $originalQuiz = $quiz;
        $course = Course::firstWhere(['slug' => $originalQuiz->course->slug]);

        // Create a new instance of the quiz with the duplicated data
        $clonedQuiz = new Quiz();
        $clonedQuiz = $originalQuiz->replicate();
        $clonedQuiz->title = $originalQuiz->title . '-' . str_random(5);
        $clonedQuiz->created_by = auth()->id();
        $clonedQuiz->course_id = $course->id ?? $originalQuiz->course_id;
        $clonedQuiz->save();

        foreach ($originalQuiz->questions as $originalQuestion) {
            $clonedQuestion = new Question();
            $clonedQuestion = $originalQuestion->replicate();
            $clonedQuestion->quiz_id = $clonedQuiz->id;
            $clonedQuestion->save();

            // Duplicate the options
            foreach ($originalQuestion->options as $originalOption) {
                $clonedOption = new QuestionOption();
                $clonedOption = $originalOption->replicate();
                $clonedOption->question_id = $clonedQuestion->id;
                $clonedOption->save();
            }
        }

        $quiz = $clonedQuiz;

        return view('jambasangsang.backend.courses.quiz.create', compact('course', 'quiz'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        try {
            if (count($quiz->submissions)) {
                LaravelFlash::withInfo('This quiz has submissions and cannot be deleted');
                return redirect()->back();
            } else {
                foreach ($quiz->questions as $question) {
                    foreach($question->options as $option) {
                        $option->delete();
                    }
                    $question->delete();
                }
                $quiz->delete();

                LaravelFlash::withSuccess('Operation Successful');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the page to start quiz.
     *
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function attempt_quiz(Request $request, $action, $quiz)
    {
        $action = $action ?? 'init';

        $quiz = Quiz::whereHas('questions')->where('status', GeneralStatus::Enabled)->firstWhere('slug', $quiz);
        $batch_user = BatchUser::firstWhere(['batch_id' => getActiveBatch()->id, 'student_id' => auth()->id()]);

        if ($action === 'attempt') {
            return view('jambasangsang.backend.courses.quiz.attempt_quiz', compact('quiz', 'batch_user'))->render();
        } else {
            return view('jambasangsang.backend.courses.quiz.init_attempt_quiz', compact('quiz', 'batch_user'))->render();
        }
    }
}
