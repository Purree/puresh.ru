<div class="row h-100 justify-content-center my-5 mt-5">
    <link rel="stylesheet" href="{{ asset('css/events/timer.css') }}">
    <script src="{{ asset('js/events/resizeTimersOnPhones.js') }}"></script>
    @can('manage_data', App\Models\Permission::class)
        <div class="d-flex justify-content-center flex-column">
            <button type="button" class="btn btn-outline-success mb-3 w-100" data-bs-toggle="collapse"
                    data-bs-target="#newEventCollapse" aria-expanded="false" aria-controls="newEventCollapse">
                Добавить новый эвент
            </button>

            <div class="collapse mb-3" id="newEventCollapse">
                <div class="card card-body">
                    <livewire:events.event-edit :wire:key="'newEvent'" />
                </div>
            </div>
        </div>
    @endcan
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body border-bottom rounded-top">
                <div class="pt-5 pb-5">
                    @foreach($events as $event)
                        <livewire:events.event :event="$event" :separators="$separators" :wire:key="$event->id"/>
                    @endforeach
                </div>
                <script src="{{ asset('js/events/timer.js') }}"></script>
                <div class="flex flex-row mt-2" wire:ignore>
                    {{ $paginator->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
