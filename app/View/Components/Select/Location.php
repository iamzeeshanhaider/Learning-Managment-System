<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\Location as ModelsLocation;
use Illuminate\View\Component;

class Location extends Component
{
    public $selected = NULL;
    public $locations;
    public string $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Location')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->locations = ModelsLocation::where('status', GeneralStatus::Enabled())->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.location');
    }
}
