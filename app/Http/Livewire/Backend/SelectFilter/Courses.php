<?php

namespace App\Http\Livewire\Backend\SelectFilter;

use App\Models\Course;
use Livewire\Component;

class Courses extends Component
{
    public $query = '';
    public $courses;
    public $selected;

    public function mount($selected)
    {
        $this->selected = $selected;
        $this->courses = Course::query()->limit(10)->get(['id', 'slug', 'title']);
    }

    public function searchBatch()
    {
        if($this->query) {
            $this->courses = Course::query()->limit(10)->where('title', 'like', '%' . $this->query . '%')->get(['id', 'slug', 'title']);
        } else {
            $this->courses = Course::query()->limit(10)->get(['id', 'slug', 'title']);
        }
    }


    public function render()
    {
        return view('livewire.backend.select-filter.courses');
    }
}
