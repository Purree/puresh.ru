<?php

namespace App\Http\Livewire\Integrations;

use App\Helpers\Integrations\VK;
use Livewire\Component;

class Integrations extends Component
{
    public bool $isVKUserDataNewToShow = false;

    public function render()
    {
        return view('livewire.integrations.integrations');
    }

    public function showVKUserData(): void
    {
        $this->isVKUserDataNewToShow = true;
    }
}
