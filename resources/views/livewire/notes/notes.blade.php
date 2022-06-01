<div>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksAndBrInText.js') }}"></script>

    @if($filtersString || !empty(current($notes)))
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-outline-success w-100 me-1" wire:click="createNewNote">{{ __('Add new note') }}
            </button>
            <button class="btn btn-outline-primary w-100 ms-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#noteFilters" aria-expanded="false">
                {{ __('Change filters') }}
            </button>
        </div>
        <div class="collapse mb-3" id="noteFilters">
            <livewire:notes.notes-filters :wire:key="'filters'"/>
        </div>
    @endif

    @forelse($notes as $note)
        @can('view', $note)
            <livewire:notes.note :note="$note" :wire:key="$note->id"/>
        @endcan

    @empty

        <div class="row h-100 justify-content-center my-5 mt-5">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body border-bottom rounded-top">
                        <div class="mx-3 my-3">
                            <h3 class="h3 my-4">
                                {{ __("You don't have any notes yet") }} {{ $filtersString ? ', ' . __('maybe this is due to the applied filters, try searching for notes without filters') : '' }}
                            </h3>
                        </div>
                    </div>
                    @if (!$filtersString)
                        <div class="card-body">
                            <div class="mx-3 my-3">
                                <div class="text">
                                    {{ __('But you can') }} <a href="#"
                                                               wire:click="createNewNote">{{ mb_strtolower(__('Create')) }}</a> {{ __('new note') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforelse


    {{-- Invisible button what trigger modal --}}
    <button data-bs-toggle="modal" data-bs-target="#deleteConfirm" id="modalTrigger" data-bs-scroll="false"
            class="d-none"></button>

    <x-photo-modal/>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title overflow-hidden"
                        id="exampleModalLabel">{{ __('Are you sure you want to delete the :note?', ['note' => $deletedNote['title'] ?? '']) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                wire:click="deleteNote({{ $deletedNote['id'] ?? 0 }})">{{ __('Yes') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $paginator->links() }}
    </div>

    {{-- Handle modal hide event and set "deletedId" to 0,
    prevent body scrolling on modal close,
    handle server answer and open modal, whan data is ready --}}
    <script>
        let scrollY = 0;

        document.addEventListener('hide.bs.modal', function () {
            @this.
            deletedNote = []
        })

        document.addEventListener('show.bs.modal', function () {
            scrollY = window.scrollY
        })

        document.addEventListener('hidden.bs.modal', function () {
            window.scrollTo(0, parseInt(scrollY || '0'));
        })


        document.addEventListener('showConfirmationModal', function () {
            document.querySelector('#modalTrigger').click()
        })
    </script>
</div>
