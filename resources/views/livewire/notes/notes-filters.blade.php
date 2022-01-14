<div>
    <script src="{{ asset('js/notes/onFilterChange.js') }}"></script>

    <form class="card card-body" wire:submit.prevent="changeNoteFilters">
        <div class="text-center h3">
            Выберите нужные вам фильтры
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <div class="h4 text-center">Порядок показа заметок</div>
            <div class="mt-3 d-flex flex-column align-items-center">

                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inIdOrderFilter" required
                               value="inIdOrder" wire:model.defer="notesOrderFilter" name="notesOrderFilter" checked>
                        <label class="form-check-label" for="inIdOrderFilter">
                            В порядке добавления
                        </label>
                    </div>
                    @can('manage_data', App\Models\Permission::class)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input noteFilterCheckbox" type="checkbox" value="filter6"
                                   id="showAllUsers" wire:model.defer="filters.showAllUsers" checked>
                            <label class="form-check-label" for="showAllUsers">
                                Показать чужие заметки
                            </label>
                        </div>
                    @endcan
                </div>

                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="userNotesFilter"
                               value="userNotes" wire:model.defer="notesOrderFilter" name="notesOrderFilter">
                        <label class="form-check-label" for="userNotesFilter">
                            Сначала мои заметки
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input noteFilterCheckbox" type="checkbox" value="filter4"
                               id="showUserNotesFilter" wire:model.defer="filters.showUserNotes" checked>
                        <label class="form-check-label" for="showUserNotesFilter">
                            Показывать мои заметки
                        </label>
                    </div>
                </div>

                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="memberNotesFilter"
                               value="memberNotes" wire:model.defer="notesOrderFilter" name="notesOrderFilter">
                        <label class="form-check-label" for="memberNotesFilter">
                            Сначала заметки, где я участник
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input noteFilterCheckbox" type="checkbox" value="filter5"
                               id="showMemberNotesFilter" wire:model.defer="filters.showMemberNotes" checked>
                        <label class="form-check-label" for="showMemberNotesFilter">
                            Показывать заметки, где я участник
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-outline-success mt-3 apply-filters">Применить фильтры</button>
    </form>
</div>
