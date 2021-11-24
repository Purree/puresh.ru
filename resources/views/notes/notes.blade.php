<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksInText.js') }}"></script>
    @foreach($notes as $note)
        <div class="noteContainer mb-5">
            <div class="noteInformation">
                <div class="fw-bold fs-3 text-truncate">
                    {{ $note->title }}
                </div>
                <div class="noteControl">
                    <div class="text-nowrap">
                        <div>Добавлено {{ date('Yг. mм. dд.  H:i:s', $note->created_at) }}</div>
                        @if($note->completed_at)
                            <div>Выполнено {{ date('Yг. mм. dд.  H:i:s', $note->completed_at) }}</div>
                        @endif
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button data-id="{{ $note->id }}" type="button" class="btn btn-secondary"><i
                                class="bi bi-pen"></i></button>
                        <button data-id="{{ $note->id }}" type="button" class="btn btn-secondary"><i
                                class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="fs-5 note-text">{{ $note->text }}</div>
                @if(!empty(current($note->images))) {{--        Get first object element and check is it empty        --}}
                    @if($note->images->count() === 1)
                        <div class="d-flex justify-content-center mt-2 imgLoading imageContainer">
                            <div class="spinner-border" role="status"></div>
                            <img class="d-none h-100 ml-auto mr-auto"
                                 src="{{ $note->images->first()->note_image_path }}">
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
                                    <div class="spinner-border position-absolute bottom-50 end-50" role="status"></div>
                                    <img src="{{ $image->note_image_path }}" class="d-block h-100 ml-auto mr-auto" alt="Note image" loading="lazy" style="margin-left: auto; margin-right: auto">
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
                Совладельцы:
                @foreach($note->user as $user)
                    <span>{{ $user->name }}</span>
                @endforeach
            </div>
            @endif
            @if(!$note->is_completed)
                <button type="button" class="btn btn-success">Выполнил</button>
            @else
                <button type="button" class="btn btn-danger" data-id="{{ $note->id }}">Отменить выполнение</button>
            @endif
        </div>
    @endforeach
    {{ $notes->onEachSide(1)->links() }}
</x-app-layout>

{{-- TODO: Адаптировать под светлую тему --}}
