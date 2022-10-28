<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Files extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CheckIsPaginatorPageExists;

    protected object $paginator;

    protected $listeners = [
        'addError' => 'throwError',
        'deleteFile' => '$refresh',
        'fileUploaded' => 'fileUploadHandler',
        'refresh' => '$refresh',
    ];

    protected string $paginationTheme = 'bootstrap';

    public array $errors = [];

    public function mount()
    {
        $this->updatePageNumber();
    }

    public function render()
    {
        $files = File::paginate(10);
        $this->paginator = $files->onEachSide(1);

        $this->validatePageNumber($this->paginator, 'files');

        return view('livewire.files.files', [
            'files' => $files,
            'paginator' => $this->paginator,
        ]);
    }

    public function throwError(string $message): void
    {
        $this->addError('key', __($message));
    }

    public function fileUploadHandler(): void
    {
        $this->emitSelf('refresh');
        session()->flash('fileUploaded', __('File added successfully'));
    }
}
