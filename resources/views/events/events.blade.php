<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/events/timer.css') }}">
    <div class="row h-100 justify-content-center my-5 mt-5">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body border-bottom rounded-top">
                    <div className="pt-5 pb-5">
                        @foreach($events as $event)
                            <p class="h1 mb-5 text-center">{{ $event->title }}</p>
                            <div id="timer" data-id="{{ $event->id }}" data-happen-at="{{ $event->happen_at }}"
                                 class="d-flex mb-3">
                                @foreach($separators as $separator)
                                    <div class="base-timer" data-type="{{ $separator }}">
                                        <svg class="base-timer__svg" viewBox="0 0 100 100"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g class="base-timer__circle">
                                                <circle class="base-timer__path-elapsed" cx="50" cy="50"
                                                        r="45"></circle>
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
                                        <span class="base-type__label">{{ ucfirst($separator) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="mt-5 mb-5">
                        @endforeach
                    </div>
                    <script src="{{ asset('js/events/timer.js') }}"></script>
                    {{ $events->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
