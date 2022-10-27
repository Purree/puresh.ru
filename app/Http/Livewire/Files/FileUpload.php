<?php

namespace App\Http\Livewire\Files;

use App\Helpers\Files\FileDrivers;
use App\Models\File;
use App\Models\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Throwable;

class FileUpload extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    protected const FILES_FOLDER = 'uploaded-files';

    public int $userId = 0; // File uploader id
    public string $name = ""; // File name, if user doesn't provide it, it will be taken from file name
    public string $path = ""; // File path after upload

    public $file;

    protected array $fileDataRules = [
        'userId' => 'required|integer',
        'name' => 'required|max:255',
        'path' => 'required|string|max:255',
    ];

    protected array $fileRules = [
        'file' => 'required|file|max:12288',
    ];

    public function render(): Factory|View|Application
    {
        return view('livewire.files.file-upload');
    }

    public function saveFile(): void
    {
        $this->authorize('manage_data', Permission::class);
        $this->validate($this->fileRules);

        $fileName = uniqid('', true) . time() . '.' . $this->file->extension();
        $filePath = self::FILES_FOLDER . '/' . $fileName;

        $this->file
            ->storePubliclyAs(self::FILES_FOLDER, $fileName, FileDrivers::getDisk());

        try {
            $this->userId = auth()->id();
            $this->name = $this->name ?: $this->file->getClientOriginalName();
            $this->path = $filePath;

            $this->validate($this->fileDataRules);

            File::create([
                'user_id' => $this->userId,
                'name' => $this->name,
                'path' => $this->path,
            ]);

            $this->emit('fileUploaded');
        } catch (Throwable  $e) {
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $this->addError('key', $e->getMessage());
        }
    }
}
