<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    protected array $filterRelation = ['memberNotes' => 'showMemberNotes', 'userNotes' => 'showUserNotes'];

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
        $isFiltersValidatedSuccessful = $this->validateFilters();
        if(!$isFiltersValidatedSuccessful){
            return $isFiltersValidatedSuccessful;
        }

        $this->emitUp('changeFilters', [$this->filters, $this->notesOrderFilter]);
    }

    private function validateFilters(): bool
    {
        if (array_key_exists('showAllUsers', $this->filters) && !\Gate::allows('manage_data', Permission::class)) {
            unset($this->filters['showAllUsers']);
        }

        if (!array_filter($this->filters)) {
            session()->flash('error', "Вы не выбрали ни одного фильтра");

            return false;
        }

        foreach ($this->filterRelation as $key => $value) {
            if($key === $this->notesOrderFilter && in_array($value, $this->filters, true)) {
                unset($this->filters[$value]);
            }
        }

        return true;
    }
}
