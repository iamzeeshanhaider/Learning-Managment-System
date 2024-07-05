<?php

namespace App\Http\Livewire\Backend\Lesson;

use App\Models\BatchUser;
use App\Models\LessonResource;
use Livewire\Component;

class Resource extends Component
{
    public $resource;
    public $courseUser;
    public bool $isCompleted = false;

    public function mount(BatchUser $courseUser, LessonResource $resource)
    {
        $this->resource = $resource;
        $this->courseUser = $courseUser;

        $completedResources = is_array($this->courseUser->completed_resources) ? $this->courseUser->completed_resources : [];
        $this->isCompleted = in_array($resource->slug, $completedResources) ? true : false;
    }

    public function render()
    {
        return view('livewire.backend.lesson.resource');
    }

    public function markCompleted()
    {
        $completedResources = is_array($this->courseUser->completed_resources) ? $this->courseUser->completed_resources : [];

        if ($this->isCompleted) {

            // Use the push method to add the item with the specified slug
            array_push($completedResources, $this->resource->slug);

            // Update the completed resources column with the modified data
            $this->courseUser->update(['completed_resources' => $completedResources]);

        } else {

            $completedResources = array_filter($completedResources, function ($item) {
                return $item != $this->resource->slug;
            });

            // Update the completed resources column with the modified data
            $this->courseUser->update(['completed_resources' => array_values($completedResources)]);
        }

        $this->emit('refreshProgress');
    }
}
