<?php

namespace App\Http\Livewire\Backend\Lesson;

use App\Models\BatchUser;
use App\Models\Quiz as ModelsQuiz;
use Livewire\Component;

class Quiz extends Component
{
    public $quiz;
    public $batchUser;
    public $submission;
    public $total_attempts;
    public $student_attempts;
    public bool $isCompleted = false;
    public $has_more_attempts = false;
    public $student_score = 0;

    public function mount(BatchUser $batchUser, ModelsQuiz $quiz)
    {
        $this->quiz = $quiz;
        $this->batchUser = $batchUser;
        $this->total_attempts = $this->quiz->attempts;

        $student = auth()->user();
        $this->student_attempts = $student->submissions()->where(['quiz_id' => $this->quiz->id])->count();
        $this->isCompleted = $student->submissions()->where(['quiz_id' => $this->quiz->id])->exists();

        $this->student_score = getAverageScore($this->quiz, $student);
        $this->has_more_attempts = intval(getAttempts($this->quiz, $student)) < $this->total_attempts ? true : false;

    }

    public function render()
    {
        return view('livewire.backend.lesson.quiz');
    }

    // public function markCompleted()
    // {
    //     $submittedQuiz = is_array($this->batchUser->submitted_quiz) ? $this->batchUser->submitted_quiz : [];

    //     if ($this->isCompleted) {

    //         // Use the push method to add the item with the specified slug
    //         array_push($submittedQuiz, $this->quiz->slug);

    //         // Update the completed resources column with the modified data
    //         $this->batchUser->update(['submitted_quiz' => $submittedQuiz]);

    //         // LaravelFlash::withSuccess('Course Completed');
    //     } else {

    //         $submittedQuizzes = array_filter($submittedQuiz, function ($item) {
    //             return $item != $this->quiz->slug;
    //         });

    //         // Update the completed resources column with the modified data
    //         $this->batchUser->update(['submitted_quiz' => array_values($submittedQuizzes)]);
    //     }

    // }

}
