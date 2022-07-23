<?php

namespace App\Http\Livewire\Notes;

use Livewire\Component;

class NotesFilters extends Component
{
    public array $filters = [];

    public string $orderBy = '';

    public function changeNoteFilters()
    {
        $this->emitUp('changeFilters');
        $this->emitUp('refreshNotes');
    }

    public function searchWithoutFilters()
    {
        $this->emitUp('clearFilters');
    }

    public function render()
    {
        return view('livewire.notes.notes-filters');
    }
}
