<div>
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
                   {{ (bool) $is_event_recurrent ? 'checked' : '' }} name="is_event_recurrent">

            <div class="form-group repetition">
                <label for="eventRepetition">Время, через которое будет повторяться событие (в секундах)</label>
                <input class="form-control @error('repetition_in_seconds') is-invalid @enderror"
                       wire:model.defer="repetition_in_seconds" id="eventRepetition"
                       placeholder="Repetition in seconds" type="number"
                       min="0" name="repetition_in_seconds">
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-danger stopEventEditing">Отмена</button>
            <button class="btn btn-success submitEvent" type="submit">Готово</button>
            <div wire:loading>
                <div class="spinner-border" role="status"></div>
            </div>
        </div>
    </form>
</div>
