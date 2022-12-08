<?php

namespace App\Http\Livewire\Integrations;

use Livewire\Component;

class Integrations extends Component
{
    public bool $isVKUserDataNeedToShow = false;

    public function render()
    {
        return view('livewire.integrations.integrations');
    }

    public function showVKUserData(): void
    {
        $this->isVKUserDataNeedToShow = true;
    }
}
