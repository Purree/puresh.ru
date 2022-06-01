<?php

namespace App\Http\Livewire\Notes;

use App\Http\Filters\NoteFilter;
use App\Models\Note;
use App\Models\Permission;
use App\Services\Livewire\NotesFiltersService;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use App\Traits\Livewire\NotesFiltersTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{
//    use NotesFiltersTrait;
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    protected object $notes;
    protected object $paginator;
    protected string $paginationTheme = 'bootstrap';

    protected $listeners = [
        'setDeletedId',
        'changeFilters' => 'changeNoteFilters',
        'refreshNotes' => '$refresh',
        'clearFilters' => 'clearFilters',
    ];

    public string $filtersString = '';
    public string $orderFilter = '';

    protected $queryString = [
        'orderFilter' => ['except' => ''],
        'filtersString' => ['except' => ''],
    ];

    public array $deletedNote = [];
    public bool $filtered = false;

    public function mount()
    {
        $this->updatePageNumber();
    }

    private function selectNotes(NoteFilter $filter)
    {
        $note = Note::filter($filter);

        if (Gate::allows('manage_data', Permission::class)) {
            $note = $note->with('user', 'images');
        } else {
            $note = $note->with('user', 'images')
                ->where('user_id', Auth::id())
                ->orWhereRelation('user', 'user_id', '=', Auth::id());
        }

        return $note->paginate(10);
    }

    public function render(NoteFilter $filter)
    {
        $filters = $filter->fields();
        $this->notesOrderFilter = $filters['orderFilter'];
        $this->filters = explode(",", $filters['filtersString']);

        $this->notes = $this->selectNotes($filter);

        $this->paginator = $this->notes->onEachSide(1);
        $this->validatePageNumber($this->paginator, 'notes');

        return view('livewire.notes.notes', ['notes' => $this->notes, 'paginator' => $this->paginator]);
    }

    public function createNewNote()
    {
        $note = new Note();
        $note->user_id = Auth::id();
        $note->title = __('Note title');
        $note->text = __('Note text');
        $note->is_completed = false;
        $note->save();

        $this->redirect(route('notes.edit', $id = $note->id));

        return false;
    }

    /**
     * Sets the deletedNote to the note of the applicant for deletion,
     * which will be stored there until the user confirms the action
     *
     * @param $note
     */
    #[NoReturn] public function setDeletedId($note): void
    {
        $this->deletedNote = $note;

        $this->dispatchBrowserEvent('showConfirmationModal');
    }

    #[NoReturn] public function deleteNote($id): void
    {
        $note = Note::findOrFail($id);

        $this->authorize('delete', $note);

        $note->delete();

        $this->emit('refreshNotes');
    }
}
