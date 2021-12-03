<div>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksInText.js') }}"></script>

    <a class="btn btn-secondary" wire:click="goBack"><i class="bi bi-arrow-left"></i></a>
    <livewire:notes.note :note="$note"/>
</div>
