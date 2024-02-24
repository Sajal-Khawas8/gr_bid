<?php

namespace App\View\Components\shared\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class select extends Component
{
    public $name, $label, $options, $dataToMatch;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $options, $label=null, $dataToMatch=null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->dataToMatch = $dataToMatch;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.select');
    }
}
