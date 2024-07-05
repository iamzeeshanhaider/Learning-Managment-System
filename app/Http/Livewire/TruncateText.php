<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TruncateText extends Component
{
    public $content;
    public $limit = 100;
    public $expanded = false;

    public function toggleExpand()
    {
        $this->expanded = !$this->expanded;
    }

    public function render()
    {
        $truncatedContent = $this->expanded ? $this->content : substr($this->content, 0, $this->limit);
        return view('livewire.truncate-text', ['truncatedContent' => $truncatedContent]);
    }
}
