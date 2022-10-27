<?php

namespace App\Http\Livewire\Files;

use App\Helpers\Files\FileDrivers;
use App\Models\File;
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
        if (Storage::disk(FileDrivers::getDisk())->exists($this->file->path)) {
            return Storage::disk(FileDrivers::getDisk())->download($this->file->path);
        }

        $this->emit('addError', 'File not found');

        return null;
    }

    public function delete(): void
    {
        $fileDeleteAttempt = $this->file->delete();
        if (! $fileDeleteAttempt->success) {
            $this->emit('addError', $fileDeleteAttempt->errorMessage);
        } else {
            $this->emit('deleteFile', $this->file);
        }
    }
}
