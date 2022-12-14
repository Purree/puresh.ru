<?php

namespace App\Http\Livewire\Notes;

use App\Exceptions\InsufficientPermissionsException;
use App\Helpers\Files\FileDrivers;
use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
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

    protected $listeners = [
        'refreshNoteImages' => '$refresh',
        'refreshUsers' => '$refresh',
        'deleteImage' => 'deleteImage',
    ];

    public string $previous;

    public object $note;

    public string $email = '';

    public string $noteTitle;

    public string $noteDescription;

    public $uploadedImage;

    public function mount($id): void
    {
        $this->note = Note::findOrFail($id);
        if (! isset($this->previous)) {
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

        $this->noteDescription = (str_replace("<br />\n", "\n", $this->noteDescription));
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
            session()->flash('message', __('User deleted successfully'));
            $this->emit('refreshUsers');
        } else {
            $this->addError('permissions', __('You do not have the required access rights'));
        }
    }

    public function addUser(): int
    {
        $this->validate($this->emailRules);

        $userId = User::where('email', $this->email)->first();
        if (! $userId) {
            // The user does not exist,
            // this is a stub so that it is not clear to the requestor that there is no such user
            session()->flash(
                'message',
                __('If the user with email :mail exists, it will be added', ['mail' => $this->email])
            );

            return 0;
        }

        $userId = $userId->id;

        if ($userId === $this->note->user_id || $this->note->user->contains($userId)) {
            $this->addError('alreadyExist', __('This user already has access to this note'));

            return 0;
        }

        $this->note->user()->attach($userId);
        session()->flash(
            'message',
            __('If the user with email :mail exists, it will be added', ['mail' => $this->email])
        );
        $this->emit('refreshUsers');

        return 1;
    }

    public function saveTextChanges(): void
    {
        $this->validate();
        $this->dispatchBrowserEvent('changesSaved');

        if (Gate::allows('update', $this->note)) {
            $this->note->title = trim($this->noteTitle);
            $this->note->text = $this->noteDescription;
            $this->note->save();
            session()->flash('updated', __('Note updated successfully'));
        } else {
            $this->addError('permissions', __("You haven't permissions"));
        }
    }

    public function cancelUpdate(): void
    {
        $this->mount($this->note->id);
    }

    public function deleteImage($imageId): bool
    {
        $image = $this->note->images()->where('id', $imageId)->first();
        try {
            $image->deleteImage($image);
        } catch (InsufficientPermissionsException|FileNotFoundException $e) {
            $this->emit('addError', $e->getMessage());
            return false;
        }

        $this->emit('refreshNoteImages');
        session()->flash('updated', __('Photo deleted successfully.'));

        return true;
    }

    public function uploadImage(): bool|MessageBag
    {
        $this->validate([
            'uploadedImage' => 'required|file|mimes:png,jpg,jpeg|max:1024',
        ]);

        if (! Gate::allows('update', $this->note)) {
            return $this->addError('permissions', __("You haven't permissions"));
        }

        if ($this->note->images()->count() >= 10) {
            return $this->addError('uploadedImage', __('This note has the maximum number of photos.'));
        }

        $fileName = $this->uploadedImage
            ->storePubliclyAs('note-images', uniqid('', true).time().'.png', FileDrivers::getDriver());

        $this->note->images()->create([
            'note_id' => $this->note->id,
            'note_image_path' => $fileName,
        ]);

        $this->emit('refreshNoteImages');
        $this->dispatchBrowserEvent('imageUploaded');
        session()->flash('updated', __('Photo added successfully.'));

        return true;
    }

    public static function getCorrectPath($fileName): string
    {
        if (Storage::disk(FileDrivers::getDriver())->has($fileName)) {
            return Storage::url($fileName);
        }

        return $fileName;
    }
}
