<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\Permission;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    protected object|array $notes;
    protected object $paginator;
    protected string $paginationTheme = 'bootstrap';

    protected $listeners = ['setDeletedId', 'changeFilters' => 'updateNotes'];

    public string $filters = '';
    public string $orderFilter = '';

    protected $queryString = [
        'filters' => ['except' => ''],
        'orderFilter' => ['except' => '']
    ];

    public array $deletedNote = [];
    public bool $filtered = false;


    public function mount() {
        $this->updatePageNumber();
    }

    public function render()
    {
        if (!$this->filtered) {
            if (Gate::allows('manage_data', Permission::class)) {
                $this->notes = Note::with('user', 'images')->paginate(10);
            } else {
                $this->notes = Note::with('user', 'images')
                    ->where('user_id', Auth::id())
                    ->orWhereRelation('user', 'user_id', '=', Auth::id())
                    ->paginate(10);
            }
        }


        $this->paginator = $this->notes->onEachSide(1);
        $this->validatePageNumber($this->paginator, 'notes');

        $this->filtered = false;

        return view('livewire.notes.notes', ['notes' => $this->notes, 'paginator' => $this->paginator]);

    }

    public function createNewNote() {
        $note = new Note();
        $note->user_id = Auth::id();
        $note->title = 'Заголовок заметки';
        $note->text = 'Текст заметки';
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
    }

    public function updateNotes($dirtyFilters)
    {
        $notes = Note::with('user', 'images');

        [$filters, $notesOrderFilter] = $dirtyFilters;

        $tempFilters = [];
        foreach ($filters as $key => $value) {
            if ($value !== false) {
                $tempFilters[] = $key;
            }
        }
        $this->filters = implode(',', $tempFilters);
        unset($tempFilters);

        $this->orderFilter = $notesOrderFilter;

        if (!array_key_exists('showAllUsers', $filters) || $filters['showAllUsers'] === false) {
            if (isset($filters['showUserNotes']) && $filters['showUserNotes']) {
                $notes = $notes->where('user_id', Auth::id());
            }

            if (isset($filters['showMemberNotes']) && $filters['showMemberNotes']) {
                $notes = $notes->orWhereRelation('user', 'user_id', '=', Auth::id());
            }
        }

        // Firstly return notes where owner is Auth user, after return all another
        if ($notesOrderFilter === 'userNotes') {
            $notes = $notes->orderBy(DB::raw('ABS(user_id-' . Auth::id() . ')'));
        }

        // Firstly return notes where collaborator is Auth user, after return all another
        if ($notesOrderFilter === 'memberNotes') {
            $notes = $notes->join('note_user', 'notes.id', '=', 'note_user.note_id')
                ->orderBy(DB::raw('ABS(note_user.user_id-' . Auth::id() . ')'));
        }

        $this->notes = $notes->paginate(10);
        $this->filtered = true;
    }
}

