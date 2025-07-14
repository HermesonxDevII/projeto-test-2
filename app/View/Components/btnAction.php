<?php

namespace App\View\Components;

use Illuminate\View\Component;

class btnAction extends Component
{
    public $action;
    public $icon;

    public function __construct($action, $icon)
    {
        $this->action = $action;
        $this->icon = $icon;
    }
    
    public function render()
    {
        return view('components.btn-action');
    }
}
