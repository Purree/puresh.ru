<div class="noteContainer mb-5 {{ $note->is_completed ? 'doneNote' : '' }}">
    <div class="noteInformation">
        <div class="fw-bold fs-3 text-truncate">
            {{ $note->title }}
        </div>
        <div class="noteControl">
            <div wire:loading class="spinner-border" role="status"></div>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('notes.edit', $id = $note->id) }}" type="button" class="btn btn-secondary d-flex align-items-center">
                    <i class="bi bi-pen"></i></a>

                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#note{{ $note->id }}Dates" aria-expanded="false" aria-controls="collapseExample">
                    <i class="bi bi-info-circle"></i>
                </button>

                <button data-id="{{ $note->id }}" type="button" wire:click="emitUpDeletedId({{$note->id}})"
                        class="btn btn-danger">
                    <i class="bi bi-trash"></i></button>

                <button type="button" class="btn {{ !$note->is_completed ? 'btn-success' : 'btn-danger' }}"
                        wire:click="changeNoteStatus({{ $note->id }})"><i
                        class="bi {{ !$note->is_completed ? 'bi-check-circle' : 'bi-x-circle' }}"></i></button>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="text-nowrap collapse card card-body position-absolute end-0" id="note{{ $note->id }}Dates">
            <div>Добавлено <wbr> {{ date('Yг. mм. dд.  H:i:s', $note->created_at) }}</div>
            @if($note->completed_at)
                <div>{{ $note->is_completed ? 'Выполнено' : 'Было выполнено' }} <wbr> {{ date('Yг. mм. dд.  H:i:s', $note->completed_at) }}</div>
            @endif
        </div>

        <div class="fs-5 note-text text-break">{{ $note->text }}</div>
        <livewire:components.notes.notes-carousel :note="$note" />
    </div>
    @if(!empty(current($note->user))) {{--        Get first object element and check is it empty        --}}
    <div>
        {{ __('Co-owners') }}:
        @foreach($note->user as $user)
            <span>{{ $user->email }}</span>
        @endforeach
    </div>
    @endif
</div>
