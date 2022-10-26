<?php

namespace App\Http\Livewire\Files;

use App\Helpers\Files\FileDrivers;
use App\Models\File;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Files extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    protected object $paginator;

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $files = File::paginate(10);
        $this->paginator = $files->onEachSide(1);

        $this->validatePageNumber($this->paginator, 'events');


        return view('livewire.files.files', [
            'files' => $files,
            'paginator' => $this->paginator,
        ]);
    }

    public function download($path): StreamedResponse
    {
        return Storage::disk(FileDrivers::getDisk())->download($path);
    }
}
