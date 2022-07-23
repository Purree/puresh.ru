<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tab extends Component
{
    public function __construct(
        public string $routeName,
        public string $text
    ) {
    }

    public function render(): View|Factory|Application
    {
        return view('components.admin.tab');
    }
}
