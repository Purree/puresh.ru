<div class="image-modal">
    @prepend('styles')
        <link rel="stylesheet" href="{{ asset('css/photo-modal.css') }}">
    @endprepend
    <script src="{{ asset('js/wheelzoom.js') }}"></script>
    <script src="{{ asset('js/photoModal.js') }}"></script>

    <span class="modal-close-button">&times;</span>
    <div class="spinner-border position-absolute bottom-50 end-50 modal-image-spinner"
         role="status"></div>
    <img class="modal-image">
    <div class="modal-caption"></div>
</div>
