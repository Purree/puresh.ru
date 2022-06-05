<div>
    @if(!empty(current($note->images)))
        {{--        Get first object element and check is it empty        --}}
        @if($note->images->count() === 1)
            <div class="d-flex justify-content-center mt-2 imgLoading imageContainer" wire:ignore>
                <div class="d-none spinner-border" role="status"></div>
                <img class="note-image h-100 ml-auto mr-auto"
                     src="{{ \App\Http\Livewire\Notes\NoteEdit::getCorrectPath($note->images->first()->note_image_path) }}"
                     style="max-width: 100%">
            </div>
        @else
            <div id="noteImagesCarousel{{ $note->id }}" class="carousel slide" data-bs-interval="false">
                <div class="carousel-indicators">
                    @for($i = 0; $i < $note->images->count(); $i++)
                        <button type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                                data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }}" aria-current="true"
                                aria-label="Slide {{ $i }}"></button>
                    @endfor
                </div>
                <div class="carousel-inner">
                    @foreach($note->images as $image)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }} imgLoading w-100 imageContainer">
                            <div class="spinner-border position-absolute bottom-50 end-50 d-none" role="status"></div>
                            <div class="d-flex h-100 mx-auto justify-content-center align-items-center">
                                @if($isEditable)
                                    <div class="position-absolute" style="right: 100px; top: 10px; z-index: 10">
                                        <button type="button" class="btn btn-outline-danger delete-image-btn"
                                                wire:click="deleteImage({{ $image->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endif
                                <img
                                    src="{{ \App\Http\Livewire\Notes\NoteEdit::getCorrectPath($image->note_image_path) }}"
                                    class="note-image d-block" loading="lazy" style="max-width: 90%">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @endif
    @endif
</div>
