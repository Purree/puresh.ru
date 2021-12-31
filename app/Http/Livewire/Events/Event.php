<?php

namespace App\Http\Livewire\Events;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Event extends Component
{
    public object $event;
    public array $separators;

    public function render(): Factory|View|Application
    {
        return view('livewire.events.event');
    }

    public function deleteEvent($id) {
        $this->emitUp('deleteEvent', $id);
    }
}
