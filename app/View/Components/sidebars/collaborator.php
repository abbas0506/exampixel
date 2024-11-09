<?php

namespace App\View\Components\sidebars;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class collaborator extends Component
{
    /**
     * Create a new component instance.
     */
    public $page;
    public function __construct($page)
    {
        //
        $this->page = $page;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebars.collaborator');
    }
}
