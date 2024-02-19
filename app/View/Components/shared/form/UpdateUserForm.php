<?php

namespace App\View\Components\shared\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpdateUserForm extends Component
{
    public $title, $action, $user, $locations;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $action, $user = null, $locations = null)
    {
        $this->title = $title;
        $this->action = $action;
        $this->user = $user ?? auth()->user();
        $this->locations = $locations;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shared.form.update-user-form');
    }
}
