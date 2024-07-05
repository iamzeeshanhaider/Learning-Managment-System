<?php

namespace App\Http\Livewire\Backend\Lesson;

use App\Models\BatchUser;
use App\Models\LessonResource;
use Livewire\Component;

class StudentResource extends Component
{
    public $resource;
    public $courseUser;
    public bool $isHidden = false;

    public function mount(BatchUser $courseUser, LessonResource $resource)
    {
        $this->resource = $resource;
        $this->courseUser = $courseUser;

        $hiddenResources = is_array($this->courseUser->hidden_resources) ? $this->courseUser->hidden_resources : [];
        $this->isHidden = in_array($resource->slug, $hiddenResources) ? true : false;
    }

    public function render()
    {
        return view('livewire.backend.lesson.student-resource');
    }

    public function markHidden()
    {
        $hiddenResources = is_array($this->courseUser->hidden_resources) ? $this->courseUser->hidden_resources : [];

        if ($this->isHidden) {

            // Use the push method to add the item with the specified slug
            array_push($hiddenResources, $this->resource->slug);

            // Update the hidden resources column with the modified data
            $this->courseUser->update(['hidden_resources' => $hiddenResources]);

        } else {

            $hiddenResources = array_filter($hiddenResources, function ($item) {
                return $item != $this->resource->slug;
            });

            // Update the hidden resources column with the modified data
            $this->courseUser->update(['hidden_resources' => array_values($hiddenResources)]);
        }
    }
}
