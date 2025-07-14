<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;
    public $color;

    public function __construct($status)
    {
        $this->status = $status == 1 ? "Ativo" : "Desativado";
        $this->color = $status == 1 ? "success" : "danger";
    }

    public function render()
    {
        return view('components.status-badge');
    }
}
