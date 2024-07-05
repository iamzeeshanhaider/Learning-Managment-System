<?php

namespace App\View\Components\Select;

use App\Models\Country as ModelsCountry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Country extends Component
{
    public $countries;
    public $selected = NULL;
    public string $label;
    public bool $isWire;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Country', $isWire = false)
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->isWire = $isWire;
        $this->countries = ModelsCountry::get(['id', 'name']);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.country');
    }
}
