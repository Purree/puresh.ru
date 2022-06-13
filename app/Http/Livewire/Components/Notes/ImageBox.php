<?php

namespace App\Http\Livewire\Components\Notes;

use Livewire\Component;
use stdClass;

class ImageBox extends Component
{
    public $listeners = [
        'test' => '$refresh'
    ];

    public $image;
    public bool $isEditable;
    public bool $isInCarousel;
    public ?bool $isActive;

    public function deleteImage(int $id): void
    {
        $this->emitUp('deleteImage', $id);
        $this->emitUp('refreshNoteImages');
    }

    public function render()
    {
        return view('livewire.components.notes.image-box');
    }
}
