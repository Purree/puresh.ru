<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\Permission;
use App\Services\Livewire\NotesFiltersService;
use App\Traits\Livewire\NotesFiltersTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NotesFilters extends Component
{
    public string $notesOrderFilter;
    public array $filters;

    public function changeNoteFilters() {
        $this->emitUp('changeFilters', $this->filters, $this->notesOrderFilter);
        $this->emitUp('refreshNotes');
    }

    public function render()
    {
        return view('livewire.notes.notes-filters');
    }
}
