<?php

namespace App\View\Components\shared\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddUserForm extends Component
{
    public $title, $action, $locations;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $action, $locations=null)
    {
        $this->title = $title;
        $this->action = $action;
        $this->locations = $locations;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.add-user-form');
    }
}
