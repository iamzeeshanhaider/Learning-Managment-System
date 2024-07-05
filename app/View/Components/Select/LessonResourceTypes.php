<?php

namespace App\View\Components\Select;

use App\Enums\LessonResourceType;
use Illuminate\View\Component;

class LessonResourceTypes extends Component
{
    public string $selected;
    public string $label;
    public $types;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Location Type')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->types = LessonResourceType::getInstances();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.lesson-resource-types');
    }
}
