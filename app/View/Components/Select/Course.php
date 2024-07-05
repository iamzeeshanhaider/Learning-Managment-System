<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\Course as ModelsCourse;
use Illuminate\View\Component;

class Course extends Component
{

    public $selected;
    public $courses;
    public string $label;
    public string $action;
    public bool $readonly;
    public bool $allowMultiple;
    public bool $isWire;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Courses', bool $readonly = false, bool $allowMultiple = false, $action = 'enrol', $isWire = false)
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->readonly = $readonly;
        $this->action = $action;
        $this->allowMultiple = $allowMultiple;
        $this->isWire = $isWire;
        $this->courses = ModelsCourse::when($this->action === 'enrol', fn($q) => $q->where('status', GeneralStatus::Enabled()))->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.course');
    }
}
