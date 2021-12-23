<div>
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <link rel="stylesheet" href="{{ asset('css/photo-modal.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksAndBrInText.js') }}"></script>
    <script src="{{ asset('js/notes/replaceTabsInTextarea.js') }}"></script>
    <script src="{{ asset('js/photoModal.js') }}"></script>

    <!-- Image modal -->
    <div class="image-modal">
        <span class="modal-close-button">&times;</span>
        <img class="modal-image">
        <div class="modal-caption"></div>
    </div>

    <div class="noteContainer mb-5">

        @error('noteTitle')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @error('noteDescription')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @if (session()->has('updated'))
            <div class="alert alert-success">
                {{ session('updated') }}
            </div>
        @endif
        <input type="text" class="form-control d-none" maxlength="50" placeholder="Название" aria-label="Название" id="titleEdit" wire:model.lazy="noteTitle">
        <div class="noteInformation" >
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
            <textarea type="text" class="form-control d-none" maxlength="2000" placeholder="Описание" aria-label="Описание" id="descriptionEdit" wire:model.lazy="noteDescription" rows="5"></textarea>
            <button class="btn btn-primary" onclick="editDescription()"><i class="bi bi-pen"></i></button>
            <div class="fs-5 note-text text-break">{{ $noteDescription }}</div>

            @if(!empty(current($note->images))) {{--        Get first object element and check is it empty        --}}
                @if($note->images->count() === 1)
                    <div class="d-flex justify-content-center mt-2 imgLoading imageContainer">
                        <div class="d-none spinner-border" role="status"></div>
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <div class="h-100 position-relative">
                                <div class="position-absolute" style="right: 10px; top: 10px; z-index: 10">
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <img class="note-image d-block h-100 w-100"
                             data-id="{{ $note->images->first()->id }}"
                             src="{{ $note->images->first()->note_image_path }}"/>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="noteImagesCarousel{{ $note->id }}" class="carousel slide" data-bs-interval="false">
                        <div class="carousel-indicators">
                            @for($i = 0; $i < $note->images->count(); $i++)
                                <button type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                                        data-bs-slide-to="{{ $i }}"
                                        class="{{ $i === 0 ? 'active' : '' }}" aria-current="true"
                                        aria-label="Slide {{ $i }}"></button>
                            @endfor
                        </div>
                        <div class="carousel-inner">
                            @foreach($note->images as $image)
                                <div
                                    class="carousel-item {{ $loop->first ? 'active' : '' }} imgLoading w-100 imageContainer">
                                    <div class="spinner-border position-absolute bottom-50 end-50 d-none"
                                         role="status"></div>
                                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                                        <div class="h-100 position-relative">
                                            <div class="position-absolute" style="right: 10px; top: 10px; z-index: 10">
                                                <button type="button" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>

                                            <img src="{{ $image->note_image_path }}"
                                                 data-id="{{ $image->id }}"
                                                 class="note-image d-block h-100 w-100"
                                                 loading="lazy" style="margin-left: auto; margin-right: auto">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button"
                                data-bs-target="#noteImagesCarousel{{ $note->id }}"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                                data-bs-target="#noteImagesCarousel{{ $note->id }}"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @endif
            @endif
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-outline-success">Добавить фотографию</button>
            </div>
        </div>
        @if(Gate::allows('forceDelete', $this->note))

            @error('permissions')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
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
                Совладельцы:
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input wire:model="email" type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
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
                                <div>{{ $user->email }}</div>
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

{{-- TODO: Photos --}}
