<?php

namespace App\View\Components\shared\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class search extends Component
{
    public $name;
    /**
     * Create a new component instance.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.search');
    }
}
