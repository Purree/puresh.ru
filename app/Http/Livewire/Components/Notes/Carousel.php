<?php

namespace App\Http\Livewire\Components\Notes;

use Livewire\Component;

class Carousel extends Component
{
    public $note;

    public bool $isEditable = false;

    protected $listeners = ['refreshNoteImages' => '$refresh'];

    public function render()
    {
        return view('livewire.components.notes.carousel');
    }
}
