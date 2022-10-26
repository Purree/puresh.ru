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

    public function download(): StreamedResponse
    {
        return Storage::disk(FileDrivers::getDisk())->download($this->file->path);
    }

    public function delete(): void
    {
        $this->file->delete();
    }
}
