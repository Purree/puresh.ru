<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use App\Models\Permission;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    protected $listeners = ['deleteEvent', 'successfullyFinishEventEditing' => 'reloadTimers', 'refresh' => '$refresh'];
    protected object $paginator;
    protected string $paginationTheme = 'bootstrap';

    public function updatedPaginators() {
        $this->reloadTimers();
    }

    public function mount() {
        $this->updatePageNumber();
    }

    public function render()
    {
        Event::validateAllDates();

        $events = Event::paginate(10);
        $this->paginator = $events->onEachSide(1);

        $this->validatePageNumber($this->paginator, 'events');

        return view('livewire.events.events', [
            'events' => $events,
            'separators' => ['days', 'hours', 'minutes', 'seconds'],
            'paginator' => $this->paginator
        ]);
    }

    public function deleteEvent($id) {
        $event = Event::findOrFail($id);

        $this->authorize('manage_data', Permission::class);

        $event->delete();

        $this->dispatchBrowserEvent('activateInactiveTimers');

        $this->emit('refresh');
    }

    public function createNewEventButtonPressed() {
        $this->authorize('manage_data', Permission::class);

        $event = new Event();
        $event->happen_at = '2222-12-32 23:59:59';
        $event->is_event_recurrent = 1;
        $event->save();
    }

    public function reloadTimers() {
        $this->emitSelf('refresh');
        $this->dispatchBrowserEvent('activateInactiveTimers');
    }
}
