<?php

namespace App\Http\Livewire\Events;

use App\Models\Permission;
use App\Models\Event as EventModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EventEdit extends Component
{
    use AuthorizesRequests;

    public object $event;

    protected array $eventEditRules = [
        'title' => 'required|max:255',
        'happen_at' => 'required|date|after:now|before:19 jun 2037',
        'is_event_recurrent' => 'required|boolean',
        'repetition_in_seconds' => 'integer|nullable',
    ];

    public string $title = 'Название события';
    public string $happen_at = '2039-01-02T12:19:00';
    public bool $is_event_recurrent = true;
    public int|null $repetition_in_seconds = null;


    public function render()
    {
        if($this->event?->happen_at ?? null) {
            $this->title = $this->event?->title;
            $this->happen_at = str_replace(' ', 'T', $this->event?->happen_at);
            $this->is_event_recurrent = $this->event?->is_event_recurrent;
            $this->repetition_in_seconds = $this->event?->repetition_in_seconds;
        }


        return view('livewire.events.event-edit');
    }

    public function saveChanges() {
        $this->authorize('manage_data', Permission::class);

        $this->validate($this->eventEditRules);

        $event = $this->event ?? new EventModel();

        $event->title = $this->title;
        $event->happen_at = $this->happen_at;
        $event->is_event_recurrent = $this->is_event_recurrent;
        $event->repetition_in_seconds = $this->repetition_in_seconds ?? null;
        $event->save();

        $this->emitUp('successfullyFinishEventEditing');
    }
}
