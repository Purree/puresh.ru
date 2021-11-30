<div>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksInText.js') }}"></script>

    @foreach($notes as $note)
        @can('view', $note)
            <livewire:notes.note :note="$note" :key="$note->id"/>
        @endcan
    @endforeach

    {{-- Invisible button what trigger modal --}}
    <button data-bs-toggle="modal" data-bs-target="#deleteConfirm" id="modalTrigger" data-bs-scroll="false"></button>
    {{ $notes->onEachSide(1)->links() }}
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить заметку {{ $deletedNote['title'] ?? '' }}?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="deleteNote({{$deletedNote['id'] ?? 0}})">Да</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Handle modal hide event and set "deletedId" to 0, handle server answer and open modal, whan data is ready --}}
    <script>
        document.addEventListener('hide.bs.modal', function () {
        @this.deletedNote
            = []
        })


        document.addEventListener('showConfirmationModal', function () {
            document.querySelector('#modalTrigger').click()
        })

        // document.addEventListener('hidden.bs.modal', function (event) {
        //     event.preventDefault()
        //     event.stopPropagation()
        // })
    </script>
</div>

{{-- TODO: Rewrite modal trigger method --}}
