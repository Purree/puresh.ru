<?php

namespace App\Http\Livewire\Components\Notes;

use Livewire\Component;

class NotesCarousel extends Component
{
    public $note;

    public function render()
    {
        return view('livewire.components.notes.notes-carousel');
    }
}
