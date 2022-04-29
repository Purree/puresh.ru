<div class="noteContainer mb-5 {{ $note->is_completed ? 'doneNote' : '' }}">
    <div class="noteInformation">
        <div class="fw-bold fs-3 text-truncate">
            {{ $note->title }}
        </div>
        <div class="noteControl">
            <div wire:loading class="spinner-border" role="status"></div>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('notes.edit', $id = $note->id) }}" type="button" class="btn btn-secondary d-flex align-items-center">
                    <i class="bi bi-pen"></i></a>

                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#note{{ $note->id }}Dates" aria-expanded="false" aria-controls="collapseExample">
                    <i class="bi bi-info-circle"></i>
                </button>

                <button data-id="{{ $note->id }}" type="button" wire:click="emitUpDeletedId({{$note->id}})"
                        class="btn btn-danger">
                    <i class="bi bi-trash"></i></button>

                <button type="button" class="btn {{ !$note->is_completed ? 'btn-success' : 'btn-danger' }}"
                        wire:click="changeNoteStatus({{ $note->id }})"><i
                        class="bi {{ !$note->is_completed ? 'bi-check-circle' : 'bi-x-circle' }}"></i></button>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="text-nowrap collapse card card-body position-absolute end-0" id="note{{ $note->id }}Dates">
            <div>Добавлено <wbr> {{ date('Yг. mм. dд.  H:i:s', $note->created_at) }}</div>
            @if($note->completed_at)
                <div>{{ $note->is_completed ? 'Выполнено' : 'Было выполнено' }} <wbr> {{ date('Yг. mм. dд.  H:i:s', $note->completed_at) }}</div>
            @endif
        </div>

        <div class="fs-5 note-text text-break">{{ $note->text }}</div>
        @if(!empty(current($note->images))) {{--        Get first object element and check is it empty        --}}
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
                        <button type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}" data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $i }}"></button>
                    @endfor
                </div>
                <div class="carousel-inner">
                    @foreach($note->images as $image)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }} imgLoading w-100 imageContainer">
                            <div class="spinner-border position-absolute bottom-50 end-50 d-none" role="status"></div>
                            <img src="{{ \App\Http\Livewire\Notes\NoteEdit::getCorrectPath($image->note_image_path) }}" class="note-image d-block h-100 me-auto ms-auto" loading="lazy" style="max-width: 90%">
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
    @if(!empty(current($note->user))) {{--        Get first object element and check is it empty        --}}
    <div>
        {{ __('Co-owners') }}:
        @foreach($note->user as $user)
            <span>{{ $user->email }}</span>
        @endforeach
    </div>
    @endif
</div>
