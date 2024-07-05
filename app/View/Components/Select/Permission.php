<?php

namespace App\View\Components\Select;

use App\Models\Permission as ModelsPermission;
use Illuminate\View\Component;

class Permission extends Component
{
    public $selected;
    public string $label;
    public string $group;
    public $permissions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected, string $label = 'Permissions', string $group = 'student')
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->group = $group;
        switch ($this->group) {
            case 'student':
                $permissions = ModelsPermission::whereIn('name', ['view_courses'])->get(['id', 'name']); // Add other students permissions when necessary
                break;

            default:
                $permissions = ModelsPermission::whereNotIn('name', ['view_admin'])->get(['id', 'name']);
                break;
        }
        $this->permissions = $permissions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.permission');
    }
}
