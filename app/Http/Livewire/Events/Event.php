<?php

namespace App\Http\Livewire\Events;

use App\Models\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Event extends Component
{
    use AuthorizesRequests;

    protected array $eventEditRules = [
        'title' => 'required|max:255',
        'happen_at' => 'required|date|after:now',
        'is_event_recurrent' => 'required|boolean',
        'repetition_in_seconds' => 'integer|nullable',
    ];

    protected $listeners = [
        'successfullyFinishEventEditing' => 'stopEventEditing',
        'stopEventEditing' => 'stopEventEditing',
    ];

    public object $event;

    public array $separators;

    public bool $isEventBeingEdited = false;

    public string $title;

    public string $happen_at;

    public bool $is_event_recurrent;

    public int|null $repetition_in_seconds = null;

    public function render(): Factory|View|Application
    {
        $this->title = $this->event->title;
        $this->happen_at = str_replace(' ', 'T', $this->event->happen_at);
        $this->is_event_recurrent = $this->event->is_event_recurrent;
        $this->repetition_in_seconds = $this->event->repetition_in_seconds;

        return view('livewire.events.event');
    }

    public function deleteEvent($id)
    {
        $this->emitUp('deleteEvent', $id);
    }

    public function editEvent()
    {
        $this->authorize('manage_data', Permission::class);

        $this->isEventBeingEdited = true;
    }

    public function stopEventEditing()
    {
        $this->authorize('manage_data', Permission::class);

        $this->isEventBeingEdited = false;

        $this->dispatchBrowserEvent('updateEventStatus', ['id' => $this->event->id]);
        $this->dispatchBrowserEvent('activateInactiveTimers');
    }
}
