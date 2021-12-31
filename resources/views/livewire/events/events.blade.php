<div class="row h-100 justify-content-center my-5 mt-5">
    <link rel="stylesheet" href="{{ asset('css/events/timer.css') }}">
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
