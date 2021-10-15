<x-app-layout>
    {{ $event = new \App\Models\Event() }}
    {{ $event->find(1)->happen_at }}
    <link rel="stylesheet" href="{{ asset('css/events/timer.css') }}">
    <div class="row h-100 justify-content-center my-5 mt-5">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body border-bottom rounded-top">
                    <div className="pt-5 pb-5">
                        <div id="timer" class="d-flex">
                            <div class="base-timer days">
                                <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <g class="base-timer__circle">
                                        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
                                        <path
                                            id="base-timer-path-remaining"
                                            stroke-dasharray="283"
                                            class="base-timer__path-remaining"
                                            d="
                                              M 50, 50
                                              m -45, 0
                                              a 45,45 0 1,0 90,0
                                              a 45,45 0 1,0 -90,0
                                            "
                                        ></path>
                                    </g>
                                </svg>
                                <span id="base-timer-label" class="base-timer__label">00</span>
                                <span class="base-type__label">Days</span>
                            </div>
                            <div class="base-timer hours">
                                <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <g class="base-timer__circle">
                                        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
                                        <path
                                            id="base-timer-path-remaining"
                                            stroke-dasharray="283"
                                            class="base-timer__path-remaining"
                                            d="
                                              M 50, 50
                                              m -45, 0
                                              a 45,45 0 1,0 90,0
                                              a 45,45 0 1,0 -90,0
                                            "
                                        ></path>
                                    </g>
                                </svg>
                                <span id="base-timer-label" class="base-timer__label">00</span>
                                <span class="base-type__label">Hours</span>
                            </div>
                            <div class="base-timer minutes">
                                <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <g class="base-timer__circle">
                                        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
                                        <path
                                            id="base-timer-path-remaining"
                                            stroke-dasharray="283"
                                            class="base-timer__path-remaining"
                                            d="
                                              M 50, 50
                                              m -45, 0
                                              a 45,45 0 1,0 90,0
                                              a 45,45 0 1,0 -90,0
                                            "
                                        ></path>
                                    </g>
                                </svg>
                                <span id="base-timer-label" class="base-timer__label">00</span>
                                <span class="base-type__label">Minutes</span>
                            </div>
                            <div class="base-timer seconds">
                                <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <g class="base-timer__circle">
                                        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
                                        <path
                                            id="base-timer-path-remaining"
                                            stroke-dasharray="283"
                                            class="base-timer__path-remaining"
                                            d="
                                              M 50, 50
                                              m -45, 0
                                              a 45,45 0 1,0 90,0
                                              a 45,45 0 1,0 -90,0
                                            "
                                        ></path>
                                    </g>
                                </svg>
                                <span id="base-timer-label" class="base-timer__label">00</span>
                                <span class="base-type__label">Seconds</span>
                            </div>
                        </div>
                    </div>
                    <script src="{{ asset('js/events/timer.js') }}"></script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
