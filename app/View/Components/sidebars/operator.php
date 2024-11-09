<?php

namespace App\View\Components\sidebars;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class operator extends Component
{
    /**
     * Create a new component instance.
     */
    public $page;
    public $questionsCount;
    public function __construct($page, $questionsCount = null)
    {
        //
        $this->page = $page;
        $this->questionsCount = $questionsCount;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebars.operator');
    }
}
