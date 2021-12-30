<?php

namespace App\Http\Livewire\Events;

use App\Http\Controllers\Traits\CheckIsPaginatorPageExists;
use App\Models\Event;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    public function render()
    {
        Event::validateAllDates();

        $events = Event::paginate(10);
        $this->updatePageNumber();
        $this->validatePageNumber($events, 'events');

        return view('livewire.events.events', [
            'events' => $events,
            'separators' => ['days', 'hours', 'minutes', 'seconds']
        ]);
    }

    public function deleteEvent($id) {
        $event = Event::findOrFail($id);

        $this->authorize('manage_data', Permission::class);

        $event->delete();
    }
}
