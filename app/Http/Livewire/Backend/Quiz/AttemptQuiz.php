<?php

namespace App\Http\Livewire\Backend\Quiz;

use App\Models\BatchUser;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\User;
use Livewire\Component;

class AttemptQuiz extends Component
{
    public $quiz;
    public $batchUser;
    public $questions;
    public $currentQuestionIndex;
    public $answers;
    public $timeRemaining;
    public $duration;
    public $countdown;
    public $session_identifier;
    public $submission_confirmation = false;
    public $submitted = false;

    public function mount(Quiz $quiz, BatchUser $batchUser)
    {
        $this->quiz = $quiz;
        $this->batchUser = $batchUser;
        $this->duration = $quiz->duration ? $quiz->duration : 30;

        if ($this->quiz && $this->quiz->questions) {
            // Map the existing questions and options to the component's data structure
            $existingQuestions = $this->quiz->questions()->with('options')->get();

            $this->questions = $existingQuestions->map(function (Question $question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'instruction' => $question->instruction,
                    'options' => $question->options->map(function (QuestionOption $option) {
                        return [
                            'id' => $option->id,
                            'option' => $option->option,
                            'is_correct' => $option->is_correct,
                        ];
                    })->toArray(),
                    'correctOption' => $question->options->pluck('is_correct')->search(true),
                ];
            })->toArray();
        }
        $this->currentQuestionIndex = 0;
        $this->answers = [];

        $this->session_identifier = auth()->user()->bio->student_id . '_quiz_timer';

        $this->setCountdownProperty();
    }

    public function setCountdownProperty()
    {
        if (session()->has($this->session_identifier)) {
            $this->countdown = session($this->session_identifier);
        } else {
            $this->countdown = $this->countdown ?? intval($this->duration * 60);
        }

        $this->updateCountdownProperty();
    }

    public function toggleConfirmation()
    {
        $this->submission_confirmation = !$this->submission_confirmation;
    }

    public function updateCountdownProperty()
    {
        if ($this->countdown <= 0) {
            $this->submitQuiz();
        } else {
            $this->countdown--;
            $this->timeRemaining = gmdate('i:s', $this->countdown);
            session([$this->session_identifier => $this->countdown]);
        }
    }

    public function goToQuestion($questionIndex)
    {
        $this->currentQuestionIndex = $questionIndex;
    }

    public function nextQuestion()
    {
        $this->currentQuestionIndex++;
    }

    public function previousQuestion()
    {
        $this->currentQuestionIndex--;
    }

    public function submitQuiz()
    {
        $student = auth()->user();

        $attempts = getAttempts($this->quiz);

        if ($attempts >= $this->quiz->attempts) {
            $message = 'You have exceeded number of quiz attempts';
        } else {
            // Perform quiz submission logic here
            // You can access the answers using $this->answers array
            $answerIds = collect($this->answers)->map(function ($answer) {
                return json_decode($answer, true)['id'];
            })->toArray();

            $attempts++;
            if (is_array($answerIds)) {
                $options = QuestionOption::findMany($answerIds);

                static::saveSubmissions($student, $this->quiz, $attempts, $options);

            } else {
                static::saveSubmissions($student, $this->quiz, $attempts, $this->questions, false);
            }

            // update batch submitted_quiz column
            $this->markQuizAsCompleted($this->batchUser, $this->quiz);
            $message = 'Quiz Submitted Succesfully';
        }

        // clear session
        session()->forget($this->session_identifier);
        $this->submitted = true;

        // Reset the component after submission
        // $this->reset();

        // Redirect to dashboard
        // TODO:: redirect to result view
        return redirect('/dashboard')->with('message', $message);
    }

    public static function saveSubmissions(User $student, Quiz $quiz, int $attempts, $options, $has_options = true)
    {
        // Save submission
        $submission = $student->submissions()->create([
            'quiz_id' => $quiz->id,
            'batch_id' => $quiz->batch->id ?? getActiveBatch()->id,
        ]);

        // save submissions data
        foreach ($options as $option) {
            $submission->data()->create([
                'question_id' => $option->question_id,
                'option_id' => $has_options ? $option->id : null,
                'is_correct' => (bool) $has_options ? $option->is_correct : false,
            ]);
        };

        // Update Student Score
        $submission->update([
            'score' => $submission->data()->sum('is_correct', true),
        ]);

        // Get Average Score

    }

    public static function markQuizAsCompleted(BatchUser $batchUser, Quiz $quiz)
    {
        $submittedQuiz = is_array($batchUser->submitted_quiz) ? $batchUser->submitted_quiz : [];

        if (!in_array($quiz->id, $submittedQuiz)) {
            array_push($submittedQuiz, $quiz->id);
        }

        // Update the completed resources column with the modified data
        $batchUser->update(['submitted_quiz' => $submittedQuiz]);
    }

    public function render()
    {
        $currentQuestion = $this->questions[$this->currentQuestionIndex];

        return view('livewire.backend.quiz.attempt-quiz', compact('currentQuestion'));
    }
}
