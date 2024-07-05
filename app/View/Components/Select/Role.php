<?php

namespace App\View\Components\Select;

use App\Models\Role as ModelsRole;
use Illuminate\View\Component;

class Role extends Component
{
    public $selected = NULL;
    public string $label;
    public string $group;
    public $roles;
    public bool $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Role', string $group = 'admin', bool $readonly = false)
    {
        $this->selected = $group === 'students' ? ModelsRole::where('name', 'student')->first() : $selected;
        $this->label = $label;
        $this->group = $group;
        $this->readonly = $readonly;
        $this->roles = ModelsRole::query()
                    ->when($this->group ?? null, fn ($query) => $query->where('name', $this->group))
                    ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.role');
    }
}
