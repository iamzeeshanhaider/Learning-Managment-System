<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use Illuminate\View\Component;

class Status extends Component
{
    public $selected = NULL;
    public $status_list;
    public string $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Status')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->status_list = collect([GeneralStatus::Enabled, GeneralStatus::Disabled]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.status');
    }
}
