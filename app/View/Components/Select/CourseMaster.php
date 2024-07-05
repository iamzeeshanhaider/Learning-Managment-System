<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\CourseMaster as ModelsCourseMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class CourseMaster extends Component
{
    public $selected = NULL;
    public $course_masters;
    public string $label;
    public bool $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, $readonly = false, string $label = 'Course Master')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->readonly = $readonly;
        $this->course_masters = ModelsCourseMaster::when(!$selected, function (Builder $query) {
                                            $query->where('status', GeneralStatus::Enabled());
                                        })->get(['id', 'name']);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.course-master');
    }
}
