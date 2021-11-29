<?php

namespace App\Http\Livewire\Notes;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Note extends Component
{
    use AuthorizesRequests;

    public object $note;

    public function render(): Factory|View|Application
    {
        return view('livewire.notes.note');
    }

    public function changeNoteStatus($id) {
        $this->authorize('update', $this->note);

        $this->note->changeCheckedStatus();
    }
}
