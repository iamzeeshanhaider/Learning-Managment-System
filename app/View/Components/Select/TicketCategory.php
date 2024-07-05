<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\TicketCategory as ModelsTicketCategory;
use Illuminate\View\Component;

class TicketCategory extends Component
{
    public $categories;
    public $selected = NULL;
    public string $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Category')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->categories = ModelsTicketCategory::where('status', GeneralStatus::Enabled())->get(['id', 'name']);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.ticket-category');
    }
}
