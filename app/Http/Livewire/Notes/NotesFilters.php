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
    use NotesFiltersTrait;

    protected $listeners = ['test'=>'test'];


    public function render()
    {
        if (isset($_GET['filters'], $_GET['orderFilter'])) {
            $this->changeNoteFilters($_GET['filters'], $_GET['orderFilter']);
        } else {
            $this->notesOrderFilter = $this->allOrderFilters[2];

    //      ['showAllUsers' => 'true', 'showMemberNotes' => 'true', 'showUserNotes' => 'true'];
            $this->filters = NotesFiltersService::associateFilters($this->allOptionalFilters);
        }

        return view('livewire.notes.notes-filters');
    }
} // TODO: Work with get params
