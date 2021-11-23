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
                    @foreach($note->images as $image)
                        <div class="d-flex justify-content-center mt-2 imgLoading">
                            <div class="spinner-border" role="status"></div>
                            <img class="d-none" width="100%"
                                 src="{{ $image->note_image_path }}">
                        </div>
                    @endforeach
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
