<x-app-layout>
    <script src="{{ asset('js/random/randomizer.js') }}" type="module"></script>
    <script src="{{ asset('js/random/randomizerHandler.js') }}" type="module"></script>
    <script src="{{ asset('js/random/selectingRandomizerHandler.js') }}" type="module"></script>
    <div class="card-body rounded">
        <div class="d-flex flex-column align-items-center flex-wrap justify-content-center">
            <div class="h3 mt-2">
                {{ __('Pseudo-random number generator') }}
            </div>
            <form class="needs-validation">
                <div>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text" id="randomFromText">{{ __('From') }}</span>
                        <label for="randomFrom"></label>
                        <input required class="form-control" aria-describedby="randomFrom" type="number" id="randomFrom">
                    </div>

                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text" id="randomToText">{{ __('To') }}</span>
                        <label for="randomTo"></label>
                        <input required class="form-control" aria-describedby="randomTo" id="randomTo" type="number">
                    </div>
                </div>
                <div class="d-flex flex-column mb-1">
                    <button class="btn btn-outline-dynamic generate-random-number-button">{{ __('Generate') }}</button>
                </div>
                <div class="text-center h2 random-result"></div>
            </form>
        </div>
    </div>

    {{-- Select random varaint --}}
    <form class="card-body rounded mt-3">
        <div>
            <div class="selected-randomizer-container">
                <div class="h3 mt-2 text-center">
                    {{ __('Selecting a pseudo-random option from a list') }}
                </div>
                <div class="d-flex align-items-baseline mb-1">
                    <div class="text-center ms-2 me-2" style="min-width: 26px">
                        <label for="selectRandomElementId">{{ __('ID') }}</label>
                        <div class="selecting-random-id" id="selectRandomElementId">1</div>
                    </div>
                    <div class="w-100 text-center">
                        <label for="selectRandomElementText">{{ __('Text') }}</label>
                        <input class="form-control random-word" type="text" id="selectRandomElementText">
                    </div>
                    <div class="w-50 text-center">
                        <label for="selectRandomElementNumber">{{ __('Chance') }}
                            <a href="#" data-bs-toggle="tooltip" data-bs-original-title=
                               "{{ __('An integer with information about how many times in a row a number must fall out in order for this element to get out (the more, the less chance)') }}">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </label>
                        <div class="d-flex">
                            <input class="form-control random-chance" type="number" min="1" max="10" id="selectRandomElementNumber" value="1">
                        </div>
                    </div>
                </div>

    {{--            A unit that js copy and paste after "add new variant" button pressed--}}
                <div class="d-flex align-items-baseline select-random-element-example mb-1">
                    <div class="text-center ms-2 me-2" style="min-width: 26px">
                        <div class="selecting-random-id">2</div>
                    </div>

                    <label class="w-100 text-center">
                        <input class="form-control random-word" type="text">
                    </label>

                    <div class="w-50 text-center">
                        <label class="d-flex chance-container">
                            <input class="form-control random-chance" type="number" min="1" max="10" value="1">
                        </label>
                    </div>
                </div>

            </div>
            <div class="d-flex flex-column align-items-center">
                <button class="btn btn-outline-dynamic mt-2 add-new-variant-button w-100">{{ __('Add a new variant') }}</button>
                <button class="btn btn-outline-dynamic mt-2 select-random-button w-100">{{ __('Select') }}</button>
                <div class="random-selecting-result h3 text-break">

                </div>
            </div>
        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new window.bootstrap.Tooltip(tooltipTriggerEl)
            })
        })
    </script>
</x-app-layout>
