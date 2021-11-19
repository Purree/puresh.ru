<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
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
                <div class="fs-5">{{ $note->text }}</div>
                {{--Если будет ссылка, отрисовывать её так, чтобы можно было кликнуть--}}
                <div class="d-flex justify-content-center mt-2 imgLoading">
                    <div class="spinner-border" role="status"></div>
                    <img class="d-none" width="100%"
                         src="https://img3.akspic.ru/originals/2/1/3/5/6/165312-atmosfera-svet-astronomicheskij_obekt-art-nauka-3840x2160.jpg">
                </div>
            </div>
            <div>
                Совладельцы:
                <span>Владимир Путин</span>,
                <span>Пладимир Вутин</span>,
                <span>Плов По-флотски</span>,
                <span>Макароны обжаренные</span>
            </div>
            @if(!$note->is_completed)
                <button type="button" class="btn btn-success">Выполнил</button>
            @else
                <button type="button" class="btn btn-danger" data-id="{{ $note->id }}">Отменить выполнение</button>
            @endif
        </div>
    @endforeach
    {{ $notes->onEachSide(1)->links() }}
</x-app-layout>
