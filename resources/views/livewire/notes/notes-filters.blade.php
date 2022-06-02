<div>
    <script src="{{ asset('js/notes/onFilterChange.js') }}"></script>

    <form method="GET" class="card card-body">
        <div class="text-center h3">
            {{ __('Choose the filters you need') }}
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
            <div class="h4 text-center">{{ __('Note display order') }}</div>
            <div class="mt-3 d-flex flex-column align-items-center">

                <div>
                    <livewire:components.notes.filter-radio :filter-name="'inIdOrderFilter'"
                                                            :filter-value="'inIdOrder'"
                                                            :filter-text="'In order of addition'"
                                                            :filter-order="$orderBy"/>
                    @can('manage_data', App\Models\Permission::class)
                        <livewire:components.notes.filter-checkbox :filter-name="'showAllUsers'"
                                                                   :filter-text="'Show other people\'s notes'"
                                                                   :filter-value="'showAllUsers'" :filters="$filters"/>
                    @endcan
                </div>

                <div>
                    <livewire:components.notes.filter-radio :filter-name="'userNotesFilter'" :filter-value="'userNotes'"
                                                            :filter-text="'First my notes'" :filter-order="$orderBy"/>
                    <livewire:components.notes.filter-checkbox :filter-name="'showUserNotesFilter'"
                                                               :filter-text="'Show my notes'"
                                                               :filter-value="'showUserNotes'" :filters="$filters"/>
                </div>

                <div>
                    <livewire:components.notes.filter-radio :filter-name="'memberNotesFilter'"
                                                            :filter-value="'memberNotes'"
                                                            :filter-text="'First notes where I\'m a member'"
                                                            :filter-order="$orderBy"/>
                    <livewire:components.notes.filter-checkbox :filter-name="'showMemberNotesFilter'"
                                                               :filter-text="'Show notes where I am a member'"
                                                               :filter-value="'showMemberNotes'" :filters="$filters"/>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row mt-3">
            <button class="btn btn-outline-success apply-filters w-100 me-1">{{ __('Apply filters') }}</button>
            <button wire:click.prevent="searchWithoutFilters"
                    class="btn btn-outline-danger w-100 ms-1">{{ __('Search without filters') }}</button>
        </div>
    </form>
</div>
