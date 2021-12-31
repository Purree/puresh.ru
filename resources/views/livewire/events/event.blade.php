<div class="unused" data-id="{{ $event->id }}">
    @if( !$isEventBeingEdited )
        <div class="mb-5 d-flex align-items-center justify-content-center">
            <p class="h1">{{ $event->title }}</p>
            @can('manage_data', App\Models\Permission::class)
                <div class="btn-group ms-3">
                    <button type="button" class="btn btn-secondary" wire:click="editEvent()"><i
                            class="bi bi-pen"></i>
                    </button>
                    <button type="button" class="btn btn-danger"
                            wire:click="deleteEvent({{ $event->id }})"><i class="bi bi-trash"></i>
                    </button>
                </div>
                <div wire:loading>
                    <div class="spinner-border text-danger" role="status"></div>
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
    @else
        <style>
            form #eventRecurrent:not(:checked) ~ .repetition {
                display: none;
            }
        </style>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form wire:submit.prevent="saveChanges">
            <div class="form-group">
                <label for="eventTitle">Название события</label>
                <input class="form-control @error('title') is-invalid @enderror" wire:model.defer="title"
                       id="eventTitle" placeholder="Title" type="text"
                       name="title" maxlength="255" required>
            </div>

            <div class="form-group">
                <label for="eventHappen">Дата</label>
                <input class="form-control @error('happen_at') is-invalid @enderror" wire:model.defer="happen_at"
                       id="eventHappen" placeholder="Happen at" type="datetime-local" name="happen_at" step="1" required>
            </div>

            <div class="form-check form-switch">
                <label for="eventRecurrent">Будет ли событие повторяться?</label>
                <input placeholder="Is event recurrent" wire:model.defer="is_event_recurrent"
                       class="form-check-input @error('is_event_recurrent') is-invalid @enderror" id="eventRecurrent"
                       type="checkbox"
                       {{ (bool) $is_event_recurrent ? 'checked' : '' }} name="is_event_recurrent" required>

                <div class="form-group repetition">
                    <label for="eventRepetition">Время, через которое будет повторяться событие (в секундах)</label>
                    <input class="form-control @error('repetition_in_seconds') is-invalid @enderror"
                           wire:model.defer="repetition_in_seconds" id="eventRepetition"
                           placeholder="Repetition in seconds" type="number"
                           min="0" name="repetition_in_seconds">
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-danger" wire:click="stopEventEditing()">Отмена</button>
                <button class="btn btn-success" type="submit">Готово</button>
                <div wire:loading>
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </form>
    @endif
    <hr class="mt-5 mb-5">
</div>
