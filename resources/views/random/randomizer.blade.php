<x-app-layout>
    <div class="card-body rounded">
        <script src="{{ asset('js/random/randomizer.js') }}" type="module"></script>
        <script src="{{ asset('js/random/randomizerHandler.js') }}" type="module"></script>
        <div class="d-flex flex-column align-items-center flex-wrap justify-content-center">
            <div class="h3 mt-2">
                Генератор псевдослучайных чисел
            </div>
            <form class="needs-validation">
                <div>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text" id="randomFromText">От</span>
                        <label for="randomFrom"></label>
                        <input required class="form-control" aria-describedby="randomFrom" type="number" id="randomFrom">
                    </div>

                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text" id="randomToText">До</span>
                        <label for="randomTo"></label>
                        <input required class="form-control" aria-describedby="randomTo" id="randomTo" type="number">
                    </div>
                </div>
                <div class="d-flex flex-column mb-1">
                    <button class="btn btn-outline-primary generate-random-number-button">Сгенерировать</button>
                </div>
                <div class="text-center h2 random-result"></div>
            </form>
        </div>
    </div>
</x-app-layout>
