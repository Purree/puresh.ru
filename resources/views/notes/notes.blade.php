<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <div class="noteContainer">
        <div class="noteInformation">
            <div class="fw-bold fs-3 text-truncate">
                Название заметки
            </div>
            <div class="noteControl">
                <div class="text-nowrap">
                    <div>Добавлено 22.03.2004</div>
                    <div>Выполнено 22.03.20004</div>
                </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary"><i class="bi bi-pen"></i></button>
                    <button type="button" class="btn btn-secondary"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="fs-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur beatae consequatur dolorum iure,
                minus molestiae nemo nihil nisi non numquam, obcaecati quas quia quidem, recusandae rem repellat
                similique veniam voluptate?
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet distinctio harum hic illo impedit nemo
                nostrum odio quo sapiente vero? Amet explicabo harum iure maxime nemo rem reprehenderit ullam ut. Lorem
                ipsum dolor sit amet, consectetur adipisicing elit. Accusantium ad blanditiis culpa dicta eligendi error
                ex ipsam, iure, non officia pariatur quisquam sapiente sint soluta ut veniam vero vitae voluptates?
            </div>
{{--            Если будет ссылка, отрисовывать её так, чтобы можно было кликнуть--}}
            <div class="d-flex justify-content-center mt-2 imgLoading">
                <div class="spinner-border" role="status"></div>
                <img class="d-none" width="100%" src="https://img3.akspic.ru/originals/2/1/3/5/6/165312-atmosfera-svet-astronomicheskij_obekt-art-nauka-3840x2160.jpg">
            </div>
        </div>
        <div>
            Совладельцы:
            <span>Владимир Путин</span>,
            <span>Пладимир Вутин</span>,
            <span>Плов По-флотски</span>,
            <span>Макароны обжаренные</span>
        </div>
        <button type="button" class="btn btn-success">Выполнил</button>
        ИЛИ ЕСЛИ ВЫПОЛНЕН:
        <button type="button" class="btn btn-danger">Отменить выполнение</button>
    </div>
</x-app-layout>
