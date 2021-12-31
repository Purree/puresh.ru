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

    protected $listeners = ['deleteEvent'];
    protected object $paginator;
    protected string $paginationTheme = 'bootstrap';


    public function render()
    {
        Event::validateAllDates();

        $events = Event::paginate(10);
        $this->paginator = $events->onEachSide(1);
        $this->updatePageNumber();
        $this->validatePageNumber($this->paginator, 'events');

        return view('livewire.events.events', [
            'events' => $events,
            'separators' => ['days', 'hours', 'minutes', 'seconds'],
            'paginator' => $this->paginator
        ]);
    }

    public function paginationView(): string
    {
        return 'pagination::tailwind';
    }

    public function deleteEvent($id) {
        $event = Event::findOrFail($id);

        $this->authorize('manage_data', Permission::class);

        $event->delete();

        $this->dispatchBrowserEvent('activateInactiveTimers');
    }
}
