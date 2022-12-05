<?php

namespace App\Http\Livewire\Integrations;

use App\Helpers\Integrations\VK;
use Livewire\Component;

class Integrations extends Component
{
    protected VK $vk;

    public function mount(VK $vk): void
    {
        $this->vk = $vk;
    }

    public function render()
    {
        return view('livewire.integrations.integrations');
    }
}
