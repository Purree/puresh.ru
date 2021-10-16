<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class EventsController extends Controller
{
    /**
     * Show all users
     *
     * @return View
     */
    public function showEvents(): View
    {
        Event::validateAllDates();

        $events = Event::paginate(10);

        return view('events.events', [
            'events' => $events,
            'separators' => ['days', 'hours', 'minutes', 'seconds']
        ]);
    }
}
