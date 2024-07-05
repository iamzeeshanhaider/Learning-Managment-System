<?php

namespace App\View\Components\Select;

use App\Models\Module as ModelsModule;
use Illuminate\View\Component;

class Module extends Component
{
    public $selected = NULL;
    public $modules;
    public string $label;
    public bool $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, $readonly = false, string $label = 'Module')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->readonly = $readonly;
        $this->modules = ModelsModule::get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.module');
    }
}
