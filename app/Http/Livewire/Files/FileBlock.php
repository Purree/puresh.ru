<?php

namespace App\Http\Livewire\Files;

use App\Exceptions\InsufficientPermissionsException;
use App\Helpers\Files\FileDrivers;
use App\Models\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileBlock extends Component
{
    public File $file;

    public function render()
    {
        return view('livewire.files.file-block', ['file' => $this->file]);
    }

    public function download(): ?StreamedResponse
    {
        if (Storage::disk(FileDrivers::getDriver())->exists($this->file->path)) {
            $fileExtension = pathinfo(storage_path($this->file->path), PATHINFO_EXTENSION);

            return Storage::disk(FileDrivers::getDriver())->download(
                $this->file->path,
                $this->file->name.($fileExtension ? ".$fileExtension" : '')
            );
        }

        $this->emit('addError', __('File not found'));

        return null;
    }

    public function delete(): void
    {
        try {
            $this->file->delete();
            $this->emit('deleteFile', $this->file);
        } catch (InsufficientPermissionsException $e) {
            $this->emit('addError', $e->getMessage());
        }
    }
}
