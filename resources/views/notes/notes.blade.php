<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksInText.js') }}"></script>
    @foreach($notes as $note)
        @can('view', $note)
            <livewire:notes.note :note="$note"/>
        @endcan
    @endforeach
    {{ $notes->onEachSide(1)->links() }}
</x-app-layout>
