<?php

namespace App\Http\Livewire\Backend\Quiz;

use App\Enums\GeneralStatus;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateQuiz extends Component
{
    public $course;
    public $quiz;
    public $validatedQuizData;
    public $disable_button;

    public $title, $description, $start_time, $end_time, $obtainable_points, $attempts, $duration, $course_id, $created_by, $status, $batch_id, $is_average; // quiz
    public $questions = []; // question

    public $currentStep = 1; // 1 = quiz, 2 = question
    public $previousStep = null;
    public $activeQuestionIndex = [];

    public function mount($course = null, $quiz = null)
    {
        $this->disable_button = false;
        $this->course = $course;
        $this->quiz = $quiz;
        $this->title = $this->quiz ? $this->quiz->title : '';
        $this->description = $this->quiz ? $this->quiz->description : '';
        $this->start_time = $this->quiz && $this->quiz->start_time ? $this->quiz->start_time->format('Y-m-d H:i')  : '';
        $this->end_time = $this->quiz && $this->quiz->end_time ? $this->quiz->end_time->format('Y-m-d H:i') : '';
        $this->obtainable_points = $this->quiz ? $this->quiz->obtainable_points : '';
        $this->attempts = $this->quiz ? $this->quiz->attempts : 1;
        $this->is_average = $this->quiz ? $this->quiz->is_average : 0;
        $this->duration = $this->quiz ? $this->quiz->duration : 60;
        $this->course_id = $this->quiz && $this->quiz->course_id ? $this->quiz->course_id : ($this->course ? $this->course->id : '');
        $this->created_by = $this->quiz ? $this->quiz->created_by : auth()->id();
        $this->status = $this->quiz && $this->quiz->status === GeneralStatus::Enabled ? true : false;
        $this->batch_id = $this->quiz->batch_id ?? getActiveBatch()->id;

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

        if (!empty($this->questions)) {
            $this->toggleAllQuestions();
        }
    }

    public function goToPreviousStep()
    {
        $this->currentStep = $this->previousStep;
        $this->previousStep = $this->previousStep !== 1 ? $this->previousStep - 1 : null;
    }

    public function goToNextStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->persistQuiz();
                break;
            case 2:
                $this->persistQuestion();
                break;
        }
    }

    public function persistQuiz()
    {
        $validatedData = $this->validate(
            [
                'title' => 'required|max:150',
                'description' => 'nullable|max:250',
                'start_time' => 'required|date',
                'end_time' => 'nullable|date|after:start_time',
                'obtainable_points' => 'required|integer',
                'attempts' => 'required|max:3',
                'is_average' => 'required_if:attempts,>,1',
                'duration' => 'required|integer',
                'course_id' => 'required|exists:courses,id',
                'status' => 'nullable',
                'batch_id' => 'required|exists:batches,id',
            ],
            [
                'course_id.required' => 'Select a Course.',
            ]
        );

        // Save validated data to database
        $this->validatedQuizData = $validatedData;

        if (empty($this->questions)) {
            $this->addQuestion();
        }

        $this->previousStep = $this->currentStep;
        $this->currentStep = $this->currentStep + 1;
    }

    public function persistQuestion()
    {
        $this->validate(
            [
                'questions.*.question' => 'required|string|min:2|max:150',
                'questions.*.instruction' => 'nullable|max:250',
                'questions.*.options.*.option' => 'required',
                'questions.*.status' => ['nullable', new EnumValue(GeneralStatus::class)],
            ],
            [
                'questions.*.question.required' => 'The question title is required.',
                'questions.*.question.max:150' => 'The question cannot exceed 150 characters.',
                'questions.*.options.*.option.required' => 'The option title is required.',
            ]
        );

        try {
            DB::beginTransaction();

            $quiz = $this->saveQuiz();

            $this->saveQuestions($quiz);

            DB::commit();

            // Clear Form
            $this->resetQuestionForm();

            // Redirect to a specific route
            $route = $this->course ? route('quiz.index', ['course' => $this->course->slug]) : route('quiz.index');

            return redirect($route)->with('message', 'Quiz saved Successfully!');

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Error Creating Quiz: ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'instruction' => '',
            'options' => [
                ['option' => '', 'is_correct' => ''],
                ['option' => '', 'is_correct' => ''],
            ],
            'correctOption' => 0,
        ];

        if (!empty($this->questions)) {
            $this->setActiveQuestionIndex(count($this->questions) - 1);
        }
    }

    public function setActiveQuestionIndex($index)
    {
        if (in_array($index, $this->activeQuestionIndex)) {
            $this->activeQuestionIndex = array_diff($this->activeQuestionIndex, [$index]);
        } else {
            $this->activeQuestionIndex[] = $index;
        }
    }

    public function toggleAllQuestions()
    {
        if (empty($this->activeQuestionIndex)) {
            $this->activeQuestionIndex = array_keys($this->questions);
        } else {
            $this->activeQuestionIndex = [];
        }
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);

        // Remove the index from activeQuestionIndex array if it exists
        $key = array_search($index, $this->activeQuestionIndex);
        if ($key !== false) {
            unset($this->activeQuestionIndex[$key]);
            $this->activeQuestionIndex = array_values($this->activeQuestionIndex);
        }
    }

    public function addOption($index)
    {
        array_push($this->questions[$index]['options'], ['option' => '', 'is_correct' => '']);
    }

    public function removeOption($questionIndex, $optionIndex)
    {
        unset($this->questions[$questionIndex]['options'][$optionIndex]);
        $this->questions[$questionIndex]['options'] = array_values($this->questions[$questionIndex]['options']);
    }

    public function resetQuestionForm()
    {
        $this->quiz = '';
        $this->questions = [];
        $this->activeQuestionIndex = [];
        $this->currentStep = 1;
    }

    public function saveQuiz()
    {
        $quiz = $this->quiz ?? new Quiz();

        $quiz->fill([
            'title' => $this->validatedQuizData['title'],
            'description' => $this->validatedQuizData['description'],
            'start_time' => $this->validatedQuizData['start_time'],
            'end_time' => $this->validatedQuizData['end_time'] ?? null,
            'obtainable_points' => $this->validatedQuizData['obtainable_points'],
            'attempts' => $this->validatedQuizData['attempts'],
            'is_average' => $this->attempts === 1 ? false : ($this->validatedQuizData['is_average'] ?? false),
            'duration' => $this->validatedQuizData['duration'],
            'course_id' => $this->validatedQuizData['course_id'],
            'status' => $this->validatedQuizData['status'] ? GeneralStatus::Enabled : GeneralStatus::Disabled,
            'batch_id' => $this->validatedQuizData['batch_id'] ?? getActiveBatch()->id,
            'created_by' => $this->created_by,
        ]);

        $quiz->save();

        return $quiz;
    }

    public function saveQuestions(Quiz $quiz)
    {
        // Get the existing questions IDs
        $existingQuestionIds = $quiz->questions->pluck('id')->toArray();

        foreach ($this->questions as $questionData) {
            // Check if the question ID exists, then update or create a new one
            $question = $quiz->questions()->updateOrCreate(
                ['id' => isset($questionData['id']) ? $questionData['id'] : null],
                [
                    'question' => $questionData['question'],
                    'instruction' => $questionData['instruction'],
                ]
            );

            // Get the existing option IDs
            $existingOptionIds = $question->options->pluck('id')->toArray();

            // Sync the options for the question
            $options = collect($questionData['options'])->map(function ($optionData, $optionIndex) use ($question, $questionData) {
                return $question->options()->updateOrCreate(['id' => isset($optionData['id']) ? $optionData['id'] : null], [
                    'option' => $optionData['option'],
                    'is_correct' => ($optionIndex == $questionData['correctOption']),
                ]);
            });

            // Delete the removed options
            if (count($existingOptionIds)) {
                $removedOptionIds = array_diff($existingOptionIds, $options->pluck('id')->toArray());
                $question->options()->whereIn('id', $removedOptionIds)->delete();
            }
        }

        // Delete any questions that were not included in the submitted data
        if (count(collect($this->questions)->pluck('id')->toArray())) {
            $deletedQuestionIds = array_diff($existingQuestionIds, collect($this->questions)->pluck('id')->toArray());

            foreach ($deletedQuestionIds as $deletedQuestionId) {
                $question = Question::find($deletedQuestionId);

                // Delete the associated options first
                $question->options()->delete();

                // Then delete the question
                $question->delete();
            }
        }
    }

    public function render()
    {
        return view('livewire.backend.quiz.create-quiz');
    }
}
