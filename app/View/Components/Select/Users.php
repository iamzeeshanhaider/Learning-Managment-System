<?php

namespace App\View\Components\Select;

use App\Enums\GeneralStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Users extends Component
{
    public $selected;
    public $users, $label;
    public $group;
    public $name;
    public bool $allowMultiple;
    public bool $readonly;
    public bool $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, $group = 'student', $name = 'user_id', $label = null, bool $allowMultiple = false, bool $readonly = false, bool $required = true)
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->group = $group;
        $this->name = $name;
        $this->allowMultiple = $allowMultiple;
        $this->readonly = $readonly;
        $this->required = $required;

        $this->users = User::query()
            ->role($this->group)
            ->when(!$selected, fn ($query) => $query->where('status', GeneralStatus::Enabled()))
            ->get();
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.users');
    }
}
