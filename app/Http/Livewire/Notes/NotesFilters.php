<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotesFilters extends Component
{
    use AuthorizesRequests;

    protected array $rules = [
        'notesOrderFilter' => ['required', 'in:memberNotes,userNotes,inIdOrder'],
        'filters' => ['required', 'array:showAllUsers,showMemberNotes,showUserNotes'],
    ];

    public string $notesOrderFilter;
    public array $filters;

    public function render()
    {
        $this->notesOrderFilter = 'inIdOrder';
        $this->filters = ['showAllUsers' => 'true', 'showMemberNotes' => 'true', 'showUserNotes' => 'true'];

        return view('livewire.notes.notes-filters');
    }

    public function changeNoteFilters()
    {
        $this->validate();
        if (array_key_exists('showAllUsers', $this->filters) && !\Gate::allows('manage_data', Permission::class)) {
            unset($this->filters['showAllUsers']);
        }

        if (!array_filter($this->filters)) {
            session()->flash('error', "Вы не выбрали ни одного фильтра");
            return false;
        }

        $this->getNotes();
    }

    private function getNotes() {
        $notes = Note::with('user', 'images');
        if (!array_key_exists('showAllUsers', $this->filters) || $this->filters['showAllUsers'] === false) {
            if($this->filters['showUserNotes']) {
                $notes = $notes->where('user_id', Auth::id());
            }

            if($this->filters['showMemberNotes']) {
                $notes = $notes->whereRelation('user', 'user_id', '=', Auth::id());
            }
        }

        if ($this->notesOrderFilter === 'userNotes') {
            $notes->orderBy("id");
        }

        dd($this->notesOrderFilter, $this->filters);
    } // TODO: Мake order by selected by user method
}
