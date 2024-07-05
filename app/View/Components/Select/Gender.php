<?php

namespace App\View\Components\Select;

use App\Enums\Gender as EnumGender;
use Illuminate\View\Component;

class Gender extends Component
{
    public $selected = NULL;
    public $genders;
    public $label;
    public bool $isWire;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, $label = 'Gender', $isWire = false)
    {
        $this->selected = $selected;
        $this->isWire = $isWire;
        $this->label = $label;
        $this->genders = EnumGender::getInstances();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.gender');
    }
}
