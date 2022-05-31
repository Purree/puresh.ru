<?php

namespace App\Http\Livewire\Notes;

use Livewire\Component;

class NotesFilters extends Component
{
    public string $notesOrderFilter;
    public array $filters;

    public function changeNoteFilters()
    {
        $this->emitUp('changeFilters', $this->filters, $this->notesOrderFilter);
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
