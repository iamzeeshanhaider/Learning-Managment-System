<?php

namespace App\View\Components\Select;

use App\Enums\LocationTypes;
use Illuminate\View\Component;

class LocationType extends Component
{
    public string $selected;
    public string $label;
    public $loc_types;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Location Type')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->loc_types = LocationTypes::getInstances();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.location-type');
    }
}
