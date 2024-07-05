<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Categories extends Component
{
    public $categories;
    public $selected = NULL;
    public string $label;
    public bool $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, $readonly = false, string $label = 'Categories')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->readonly = $readonly;
        $this->categories = Category::when(!$selected, function (Builder $query) {
            $query->where('status', GeneralStatus::Enabled());
        })->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.categories');
    }
}
