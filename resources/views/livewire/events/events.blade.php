<div class="row h-100 justify-content-center my-5 mt-5">
    <link rel="stylesheet" href="{{ asset('css/events/timer.css') }}">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body border-bottom rounded-top">
                <div className="pt-5 pb-5">
                    @foreach($events as $event)
                        <div class="mb-5 d-flex align-items-center justify-content-center">
                            <p class="h1">{{ $event->title }}</p>
                            @can('manage_data', App\Models\Permission::class)
                                <div class="btn-group ms-3">
                                    <button type="button" class="btn btn-secondary"><i class="bi bi-pen"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </div>
                            @endcan
                        </div>
                        <div id="timer" data-id="{{ $event->id }}" data-happen-at="{{ $event->happen_at }}"
                             class="d-flex mb-3">
                            @foreach($separators as $separator)
                                <div class="base-timer d-flex align-items-center" data-type="{{ $separator }}">
                                    <svg class="base-timer__svg" viewBox="0 0 100 100"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g class="base-timer__circle">
                                            <circle class="base-timer__path-elapsed" cx="50" cy="50"
                                                    r="45"></circle>
                                            <path
                                                id="base-timer-path-remaining"
                                                stroke-dasharray="283"
                                                class="base-timer__path-remaining {{ $separator }}"
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
