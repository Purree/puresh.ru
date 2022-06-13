<div
    class="{{ $isInCarousel ? 'carousel-item ' . ($isActive ? 'active' : '') : '' }} imgLoading imageContainer w-100"
>
{{--    {{ dump($isInCarousel) }}--}}
{{--    {{ dump($isActive) }}--}}
    <div class="d-flex position-relative h-100 mx-auto justify-content-center align-items-center">
        <div class="spinner-border position-absolute bottom-50 end-50 d-none" role="status"></div>
        @if($isEditable)
            <div class="position-absolute top-0 start-50" style="z-index: 10; transform: translateX(-50%);">
                <button type="button" class="btn btn-outline-danger delete-image-btn"
                        wire:click="deleteImage({{ $image->id }})">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        @endif
        <img class="note-image h-100 ml-auto mr-auto"
             src="{{ \App\Http\Livewire\Notes\NoteEdit::getCorrectPath($image->note_image_path) }}"
             style="max-width: 90%">
    </div>
</div>
