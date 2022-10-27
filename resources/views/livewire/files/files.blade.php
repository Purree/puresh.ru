<div class="row h-100 justify-content-center">
    @prepend('styles')
        <link rel="stylesheet" href="{{ asset('css/files/files.css') }}">
    @endprepend
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('fileUploaded'))
        <div class="alert alert-success">
            {{ session('fileUploaded') }}
        </div>
    @endif
    @can('manage_data', App\Models\Permission::class)
        <div class="d-flex justify-content-center flex-column">
            <button type="button" class="btn btn-outline-success mb-3 w-100" data-bs-toggle="collapse"
                    data-bs-target="#newFileCollapse" aria-expanded="false" aria-controls="newFileCollapse">
                {{ __('Add new file') }}
            </button>

            <div class="collapse mb-3" id="newFileCollapse">
                <div class="card card-body">
                    <livewire:files.file-upload :wire:key="'newFile'"/>
                </div>
            </div>
        </div>
    @endcan
    <div class="card shadow">
        <div class="card-body border-bottom rounded-top">
            @if($files->count() !== 0)
                <div class="pb-5">
                    @foreach($files as $file)
                        <livewire:files.file-block :file="$file" :key="$file->id"/>
                        @if (!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="h3">
                    {{ __('No files yet') }}
                </p>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $paginator->links() }}
    </div>
</div>
