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

    protected function rules()
    {
        return [
            'notesOrderFilter' => ['required', "in:" . implode(',', $this->allOrderFilters)],
            'filters' => ['required', 'array:' . implode(',', $this->allOptionalFilters)],
        ];
    }

    protected array $allOrderFilters = ['memberNotes', 'userNotes', 'inIdOrder'];
    protected array $allOptionalFilters = ['showAllUsers', 'showMemberNotes', 'showUserNotes'];

    public string $notesOrderFilter;
    public array $filters;


    public function render()
    {
        $this->notesOrderFilter = $this->allOrderFilters[2];

//              ['showAllUsers' => 'true', 'showMemberNotes' => 'true', 'showUserNotes' => 'true'];
        $this->filters = array_map(static fn($v) => 'true', array_flip($this->allOptionalFilters));

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


    private function getNotes()
    {
        $notes = Note::with('user', 'images');
        if (!array_key_exists('showAllUsers', $this->filters) || $this->filters['showAllUsers'] === false) {
            if ($this->filters['showUserNotes']) {
                $notes = $notes->where('user_id', Auth::id());
            }

            if ($this->filters['showMemberNotes']) {
                $notes = $notes->orWhereRelation('user', 'user_id', '=', Auth::id());
            }
        }

        if ($this->notesOrderFilter === 'userNotes') {
        }

        dd($this->notesOrderFilter, $this->filters);
    } // TODO: Make order by selected by user method


    private function removeMutuallyExclusiveFilters()
    {
    }

}
