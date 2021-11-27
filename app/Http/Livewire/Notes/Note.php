<?php

namespace App\Http\Livewire\Notes;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Note extends Component
{
    public object $note;

    public function render(): Factory|View|Application
    {
        return view('livewire.notes.note');
    }

    public function changeNoteStatus($id) {
        dd($id);
    }
}
