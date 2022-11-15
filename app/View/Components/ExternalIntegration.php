<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ExternalIntegration extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $serviceLogo,
        public string $serviceName,
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
        return view('components.external-integration');
    }
}
