<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\Lesson as ModelsLesson;
use Illuminate\View\Component;

class Lesson extends Component
{
    public $selected = NULL;
    public string $label;
    public bool $readonly;
    public $lessons;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, bool $readonly = false, string $label = 'Lesson')
    {
        $this->selected = $selected;
        $this->readonly = $readonly;
        $this->label = $label;
        $this->lessons = ModelsLesson::when(!$selected, function ($q) {
                    $q->where('status', GeneralStatus::Enabled());
                })->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.lesson');
    }
}
