<?php

namespace App\View\Components\Integrations;

use Illuminate\View\Component;

class Block extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $serviceLogo,
        public string $cardColor = 'inherit',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.integrations.block');
    }
}
