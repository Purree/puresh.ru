<div key="note-edit">
    <link rel="stylesheet" href="{{ asset('css/notes/note.css') }}">
    <link rel="stylesheet" href="{{ asset('css/photo-modal.css') }}">
    <script src="{{ asset('js/notes/imgLoading.js') }}"></script>
    <script src="{{ asset('js/notes/replaceLinksAndBrInText.js') }}"></script>
    <script src="{{ asset('js/notes/replaceTabsInTextarea.js') }}"></script>
    <script src="{{ asset('js/notes/noteUpload.js') }}"></script>

    <!-- Image modal -->
    <div class="image-modal">
        <span class="modal-close-button">&times;</span>
        <div class="spinner-border position-absolute bottom-50 end-50 modal-image-spinner"
             role="status"></div>
        <img class="modal-image">
        <div class="modal-caption"></div>
    </div>

    <!-- Add photos modal -->
    <form wire:ignore.self wire:submit.prevent="uploadImage" class="modal fade" id="addNewPhotoModal" tabindex="-1" aria-labelledby="addNewPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewPhotoModalLabel">Добавить фото</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @error('uploadedImage') <span class="d-flex justify-content-center alert-danger mb-3 previewError">{{ $message }}</span> @enderror
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <img wire:ignore class="selectedPhotoPreview d-none h-100 w-100 mb-3" style="max-height: 70vh" src="#" alt="Selected image" />
                        <input class="selectPhoto" wire:model="uploadedImage" wire:key="photoModal" type="file" accept="image/jpeg,image/png,image/jpg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </form>

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

            @if(!empty(current($noteImages))) {{--        Get first object element and check is it empty        --}}
            <script src="{{ asset('js/photoModal.js') }}"></script>
                @if($noteImages->count() === 1)
                    <div class="d-flex justify-content-center mt-2 imgLoading imageContainer">
                        <div class="d-none spinner-border" role="status"></div>
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center imageBlock">
                            <div class="h-100 position-relative">
                                <div class="position-absolute" style="right: 10px; top: 10px; z-index: 10">
                                    <button type="button" class="btn btn-outline-danger delete-image-btn" wire:click="deleteImage({{ $noteImages->first()->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <img class="note-image d-block h-100 w-100"
                                    src="{{ self::getCorrectPath($noteImages->first()->note_image_path) }}"/>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="noteImagesCarousel{{ $note->id }}" class="carousel slide" data-bs-interval="false">
                        <div class="carousel-indicators">
                            @for($i = 0; $i < $noteImages->count(); $i++)
                                <button type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                                        data-bs-slide-to="{{ $i }}"
                                        class="{{ $i === 0 ? 'active' : '' }}" aria-current="true"
                                        aria-label="Slide {{ $i }}"></button>
                            @endfor
                        </div>
                        <div class="carousel-inner">
                            @foreach($noteImages as $image)
                                <div
                                    class="carousel-item {{ $loop->first ? 'active' : '' }} imgLoading w-100 imageContainer">
                                    <div class="spinner-border position-absolute bottom-50 end-50 d-none"
                                         role="status"></div>
                                    <div class="w-100 h-100 d-flex justify-content-center align-items-center imageBlock">
                                        <div class="h-100 position-relative">
                                            <div class="position-absolute delete-image-btn" style="right: 10px; top: 10px; z-index: 10">
                                                <button type="button" class="btn btn-outline-danger" wire:click="deleteImage({{ $image->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>

                                            <img src="{{ self::getCorrectPath($image->note_image_path) }}"
                                                 class="note-image d-block h-100 w-100 ms-auto me-auto"
                                                 loading="lazy">
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
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addNewPhotoModal">
                    Добавить фотографию
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
