<?php

namespace App\View\Components\Select;

use App\Models\Batch as ModelsBatch;
use Illuminate\View\Component;

class Batch extends Component
{

    public $selected = null;
    public $batches;
    public string $label;
    public bool $required;
    public bool $multiple;
    public bool $readonly;
    public bool $isWire;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Batch', $required = true, $multiple = false, $readonly = false, $isWire = false)
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->isWire = $isWire;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->readonly = $readonly;
        $this->batches = ModelsBatch::get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.batch');
    }
}
