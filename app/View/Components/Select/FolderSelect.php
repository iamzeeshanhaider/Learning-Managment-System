<?php

namespace App\View\Components\Select;

use App\Models\Lesson;
use Illuminate\View\Component;

class FolderSelect extends Component
{

    public $selected = NULL;
    public Lesson $lesson;
    public $folders, $label;
    public bool $required;
    public bool $readonly;
    public bool $isWire;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Lesson $lesson, $selected, string $label = 'Folder', $required = true, $readonly = false, $isWire = false)
    {
        $this->selected = $selected;
        $this->lesson = $lesson;
        $this->label = $label;
        $this->isWire = $isWire;
        $this->required = $required;
        $this->readonly = $readonly;
        $this->folders = $this->lesson->folders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select.folder-select');
    }
}
