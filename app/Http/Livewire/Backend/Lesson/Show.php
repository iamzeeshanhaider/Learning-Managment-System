<?php

namespace App\Http\Livewire\Backend\Lesson;

use App\Models\BatchUser;
use App\Models\Lesson;
use Livewire\Component;

class Show extends Component
{
    public $lesson;
    public $courseUser;
    public $slug;
    public $view;
    public int $progress = 0, $total_resources = 0;

    protected $listeners = ['refreshProgress'];

    public function mount(Lesson $lesson, BatchUser $courseUser, $view = null)
    {
        $this->lesson = $lesson;
        $this->slug = $lesson->slug;
        $this->courseUser = $courseUser;
        $this->view = $view;
        $this->getProgress();
    }

    public function refreshProgress()
    {
        $this->getProgress();
    }

    public function getProgress()
    {
        $this->progress = getCompletedResource($this->courseUser, $this->lesson);
        $this->total_resources = getResourceCount($this->lesson);

    }

    public function render()
    {
        return view('livewire.backend.lesson.show');
    }
}
