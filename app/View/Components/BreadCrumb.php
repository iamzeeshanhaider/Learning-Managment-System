<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BreadCrumb extends Component
{
    public string $pageTitle;
    public string $previous;
    public string $previousLink;
    public string $current;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $pageTitle, string $previous = null, string $previousLink = null, string $current)
    {
        $this->pageTitle = $pageTitle;
        $this->previous = $previous;
        $this->previousLink = $previousLink;
        $this->current = $current;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bread-crumb');
    }
}
