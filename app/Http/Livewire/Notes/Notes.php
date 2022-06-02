<?php

namespace App\Http\Livewire\Notes;

use App\Http\Filters\NoteFilter;
use App\Models\Note;
use App\Models\Permission;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    protected object $notes;
    protected object $paginator;
    protected string $paginationTheme = 'bootstrap';

    protected $listeners = [
        'setDeletedId',
        'refreshNotes' => '$refresh',
        'clearFilters' => 'clearFilters',
    ];

    public array $filters = [];
    public string $orderFilter = '';

    protected $queryString = [
        'orderFilter' => ['except' => ''],
        'filters' => ['except' => ''],
    ];

    public array $deletedNote = [];

    public function mount()
    {
        $this->updatePageNumber();
    }

    private function selectNotes(NoteFilter $filter)
    {
        $note = Note::with('user', 'images');

        if (!Gate::allows('manage_data', Permission::class)) {
            $note = $note->where('user_id', Auth::id())
                ->orWhereRelation('user', 'user_id', '=', Auth::id());
        }

        return $note->filter($filter)->paginate(10);
    }

    public function render(NoteFilter $filter)
    {
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
    public function setDeletedId($note): void
    {
        $this->deletedNote = $note;

        $this->dispatchBrowserEvent('showConfirmationModal');
    }

    public function deleteNote($id): void
    {
        $note = Note::findOrFail($id);

        $this->authorize('delete', $note);

        $note->delete();

        $this->emit('refreshNotes');
    }

    public function clearFilters(): void
    {
        $this->filters = [];
        $this->orderFilter = '';
    }
}
