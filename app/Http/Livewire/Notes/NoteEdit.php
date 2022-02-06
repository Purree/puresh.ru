<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use App\Models\NoteImage;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Livewire\Component;
use Livewire\WithFileUploads;

class NoteEdit extends Component
{
    use WithFileUploads;
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
    public $uploadedImage;

    public function mount($id): void
    {
        $this->note = Note::findOrFail($id);
        if (!isset($this->previous)) {
            $this->previous = url()->previous() !== url()->current() ? url()->previous() : route('notes');
        }

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

    public function goBack(): Redirector|Application|RedirectResponse
    {
        return redirect($this->previous);
    }

    public function deleteUser($id): void
    {
        if (Gate::allows('forceDelete', $this->note)) {
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
        if (!$userId) {
            // The user does not exist,
            // this is a stub so that it is not clear to the requestor that there is no such user
            session()->flash('message', "Если пользователь с email $this->email существует, он будет добавлен");
            return 0;
        }

        $userId = $userId->id;

        if ($userId === $this->note->user_id || $this->note->user->contains($userId)) {
            $this->addError('alreadyExist', 'Этот пользователь уже имеет доступ к этой заметке');
            return 0;
        }

        $this->note->user()->attach($userId);
        session()->flash('message', "Если пользователь с email $this->email существует, он будет добавлен");
        $this->emit('refreshUsers');
        return 1;
    }

    public function saveTextChanges(): void
    {
        $this->validate();
        $this->dispatchBrowserEvent('contentChanged');
        $this->dispatchBrowserEvent('changesSaved');

        if (Gate::allows('update', $this->note)) {
            $this->note->title = trim($this->noteTitle);
            $this->note->text = $this->noteDescription;
            $this->note->save();
            session()->flash('updated', "Заметка успешно обновлена");
        } else {
            $this->addError('permissions', 'You haven\'t permissions');
        }
    }

    public function cancelUpdate(): void
    {
        $this->mount($this->note->id);
    }

    public function deleteImage($imageId): bool|MessageBag
    {
        $image = $this->note->images()->where('id', $imageId)->first();
        $imageDeletionResult = $image->deleteImage($image);

        if (!$imageDeletionResult->success) {
            return $this->addError($imageDeletionResult->errorMessage[0], $imageDeletionResult->errorMessage[1]);
        }

        $this->emit('refreshNoteImages');
        session()->flash('updated', "Фотография успешно удалена.");
        return true;
    }

    public function uploadImage(): bool|MessageBag
    {
        $this->validate([
            'uploadedImage' => 'required|file|mimes:png,jpg,jpeg|max:1024'
        ]);

        if (!Gate::allows('update', $this->note)) {
            return $this->addError('permissions', 'You haven\'t permissions');
        }

        if ($this->note->images()->count() >= 10) {
            return $this->addError('uploadedImage', 'У этой заметки максимальное количество фотографий');
        }

        $fileName = $this->uploadedImage
            ->storePubliclyAs('note-images', uniqid('', true) . '.png', NoteImage::profilePhotoDisk());

        $this->note->images()->create([
            'note_id' => $this->note->id,
            'note_image_path' => $fileName
        ]);

        $this->emit('refreshNoteImages');
        $this->dispatchBrowserEvent('imageUploaded');
        session()->flash('updated', "Фотография успешно добавлена.");
        return true;
    }

    public static function getCorrectPath($fileName): string
    {
        if (Storage::disk(NoteImage::profilePhotoDisk())->has($fileName)) {
            return Storage::url($fileName);
        }

        return $fileName;
    }
}
