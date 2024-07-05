<?php

namespace App\View\Components\Select;

use App\Enums\QuizTypes;
use Illuminate\View\Component;

class QuizType extends Component
{
    public $selected = NULL;
    public string $label;
    public $quizTypes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Quiz Type')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->quizTypes = QuizTypes::getInstances();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.quiz-type');
    }
}
