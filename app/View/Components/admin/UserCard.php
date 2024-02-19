<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{
    public $user, $updateAction, $deleteAction;
    /**
     * Create a new component instance.
     */
    public function __construct($user, $updateAction=null, $deleteAction=null)
    {
        $this->user = $user;
        $this->updateAction = $updateAction;
        $this->deleteAction = $deleteAction;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.user-card');
    }
}
