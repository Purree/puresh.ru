<div key="note-edit">
    @prepend('styles')
        <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    @endprepend
    <script src="{{ asset('js/notes/preventTabClosingOnNoteEditing.js') }}"></script>
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksAndBrInText.js') }}"></script>
    <script src="{{ asset('js/notes/replaceTabsInTextarea.js') }}"></script>
    <script src="{{ asset('js/notes/noteUpload.js') }}"></script>

    <x-photo-modal/>

    <!-- Upload photos modal -->
    <form wire:ignore.self wire:submit.prevent="uploadImage" class="modal fade" id="addNewPhotoModal" tabindex="-1"
          aria-labelledby="addNewPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewPhotoModalLabel">{{ __('Select A New Photo') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @error('uploadedImage') <span
                        class="d-flex justify-content-center alert-danger mb-3 previewError">{{ $message }}</span> @enderror
                    <div class="d-flex justify-content-center align-items-center flex-column flex-wrap">
                        <img wire:ignore class="selectedPhotoPreview d-none h-100 w-100 mb-3" style="max-height: 70vh"
                             src="#" alt="Selected image"/>
                        <input class="selectPhoto" wire:model="uploadedImage" wire:key="photoModal" type="file"
                               accept="image/jpeg,image/png,image/jpg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </form>

    <div class="noteContainer mb-5">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        @if (session()->has('updated'))
            <div class="alert alert-success">
                {{ session('updated') }}
            </div>
        @endif
        <input type="text" class="form-control d-none" maxlength="50" placeholder="Название" aria-label="Название"
               id="titleEdit" wire:model.lazy="noteTitle">
        <div class="noteInformation">
            <button class="btn btn-primary" onclick="editTitle()"><i class="bi bi-pen"></i></button>
            <div class="fw-bold fs-3 text-truncate">
                {{ $noteTitle }}
            </div>

            <div class="noteControl">
                <div wire:loading class="spinner-border" role="status"></div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-secondary" wire:click="goBack"><i class="bi bi-arrow-left"></i></a>

                    <button type="button" wire:click="cancelUpdate"
                            class="btn btn-danger">
                        <i class="bi bi-x-circle"></i></button>

                    <button type="button" class="btn btn-success"
                            wire:click="saveTextChanges"><i
                            class="bi bi-check-circle"></i></button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <textarea type="text" class="form-control d-none" maxlength="2000" placeholder="Описание"
                      aria-label="Описание" id="descriptionEdit" wire:model.lazy="noteDescription" rows="5"></textarea>
            <button class="btn btn-primary" onclick="editDescription()"><i class="bi bi-pen"></i></button>
            <div class="fs-5 note-text text-break">{{ $noteDescription }}</div>

            <livewire:components.notes.carousel :note="$note" :isEditable="true"/>
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addNewPhotoModal">
                    {{ __('Select A New Photo') }}
                </button>
            </div>
        </div>
        @if(Gate::allows('forceDelete', $this->note))

            @error('permissions')
            <div class="alert alert-danger" role="alert">{{ __($message) }}</div>
            @enderror

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('alreadyExist')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div>
                {{ __('Co-owners') }}:
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input wire:model="email" type="text" class="form-control" placeholder="Email" aria-label="Email"
                           aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" wire:click="addUser">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                </div>
                <div>
                    @if(!empty(current($note->user)))
                        @foreach($note->user as $user)
                            <div class="d-flex align-items-center m-2">
                                <button class="btn btn-danger me-2" wire:click="deleteUser({{ $user->id }})"><i
                                        class="bi bi-dash-circle m"></i></button>
                                <div class="text-break">{{ $user->email }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function editTitle() {
        document.querySelector('#titleEdit').classList.remove('d-none')
    }

    function editDescription() {
        document.querySelector('#descriptionEdit').classList.remove('d-none')
    }
</script>
