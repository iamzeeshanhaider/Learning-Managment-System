<?php

namespace App\View\Components\Select;

use App\Enums\Ethnicity as EnumEthnicity;

use Illuminate\View\Component;

class Ethnicity extends Component
{
    public $selected = NULL;
    public string $label;
    public bool $isWire;
    public $ethnicities;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Ethnicity', $isWire = false)
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->isWire = $isWire;
        $this->ethnicities =  EnumEthnicity::getInstances();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.ethnicity');
    }
}
