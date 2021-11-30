<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class Notes extends Component
{
    use AuthorizesRequests;

    protected object $notes;

    protected $listeners = ['setDeletedId'];

    public array $deletedNote = [];

    public function render()
    {
        if(Gate::allows('manage_data', Permission::class)){
            $this->notes = Note::with('user', 'images')->paginate(10);
        } else {
            $this->notes = Note::with('user', 'images')
                ->where('user_id', Auth::id())
                ->orWhereRelation('user', 'user_id', '=', Auth::id())
                ->paginate(10);
        }

        return view('livewire.notes.notes', ['notes' => $this->notes]);
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
        $note = Note::find($id);

        $this->authorize('delete', $note);

        $note->delete();
    }
}
