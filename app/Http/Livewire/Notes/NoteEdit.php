<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class NoteEdit extends Component
{
    use AuthorizesRequests;

    public string $previous;
    public object $note;

    public function mount($id): void
    {
        $this->note = Note::findOrFail($id);

        $this->previous = url()->previous();
    }

    public function render(): Factory|View|Application
    {
        $this->authorize('update', $this->note);

        return view('livewire.notes.note-edit');
    }

    public function goBack()
    {
        return redirect($this->previous);
    }
}
