<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class NoteEdit extends Component
{
    use AuthorizesRequests;

    protected array $emailRules = [
        'email' => 'required|email',
    ];

    protected array $rules = [
        'noteTitle' => 'required|string|max:50',
        'noteDescription' => 'required|string|max:2000',
    ];

    protected $listeners = ['refreshNoteImages' => '$refresh', 'refreshUsers' => '$refresh'];

    public string $previous;
    public object $note;
    public string $email = '';
    public string $noteTitle;
    public string $noteDescription;

    public function mount($id): void
    {
        $this->note = Note::findOrFail($id);

        $this->previous = url()->previous() !== url()->current() ? url()->previous() : route('notes');

        $this->noteTitle = $this->note->title;
        $this->noteDescription = $this->note->text;
    }

    public function getNoteImagesProperty()
    {
        return $this->note->images;
    }

    public function render(): Factory|View|Application
    {
        $this->authorize('update', $this->note);
        $this->noteDescription = nl2br($this->noteDescription);
        $this->dispatchBrowserEvent('contentChanged');

        return view('livewire.notes.note-edit', [
            'noteImages' => $this->noteImages,
        ]);
    }

    public function goBack()
    {
        return redirect($this->previous);
    }

    public function deleteUser($id): void
    {
        if(Gate::allows('forceDelete', $this->note)){
            $this->note->user()->detach($id);
            session()->flash('message', "Пользователь успешно удалён");
            $this->emit('refreshUsers');
        } else {
            $this->addError('permissions', 'У вас нет нужных прав доступа');
        }
    }

    public function addUser(): int
    {
        $this->validate($this->emailRules);

        $userId = User::where('email', $this->email)->first();
        if(!$userId) {
            // The user does not exist, this is a stub so that it is not clear to the requestor that there is no such user
            session()->flash('message', "Если пользователь с email $this->email существует, он будет добавлен");
            return 0;
        }

        $userId = $userId->id;

        if($userId === $this->note->user_id || $this->note->user->contains($userId)) {
            $this->addError('alreadyExist', 'Этот пользователь уже имеет доступ к этой заметке');
            return 0;
        }

        $this->note->user()->attach($userId);
        session()->flash('message', "Если пользователь с email $this->email существует, он будет добавлен");
        $this->emit('refreshUsers');
        return 1;
    }

    public function saveTextChanges() {
        $this->validate();
        $this->dispatchBrowserEvent('contentChanged');

        if(Gate::allows('update', $this->note)){
            $this->note->title = trim($this->noteTitle);
            $this->note->text = $this->noteDescription;
            $this->note->save();
            session()->flash('updated', "Заметка успешно обновлена");
        } else {
            $this->addError('permissions', 'You haven\'t permissions');
        }
    }

    public function cancelUpdate() {
        $this->mount($this->note->id);
    }

    public function deleteImage($imageId)
    {
        $image = $this->note->images()->where('id', $imageId)->first();
        $imageDeletionResult = $image->deleteImage($image);
        if(is_array($imageDeletionResult) && array_key_exists('error', $imageDeletionResult)){
            return $this->addError($imageDeletionResult['error'][0], $imageDeletionResult['error'][1]);
        }

        $this->emit('refreshNoteImages');
        session()->flash('updated', "Фотография успешно удалена.");
        return true;
    }
}
