<div class="row h-100 justify-content-center">
    @prepend('styles')
        <link rel="stylesheet" href="{{ asset('css/files/files.css') }}">
    @endprepend
    @can('manage_data', App\Models\Permission::class)
        <div class="d-flex justify-content-center flex-column">
            <button type="button" class="btn btn-outline-success mb-3 w-100">
                {{ __('Add new file') }}
            </button>
        </div>
    @endcan
    <div class="card shadow">
        <div class="card-body border-bottom rounded-top">
            @if($files->count() !== 0)
                <div class="pb-5">
                    @foreach($files as $file)
                        <div class="d-flex justify-content-between align-items-center text-break flex-column">
                            <div class="d-flex w-100 flex-column">
                                <div class="h5">
                                    {{ $file->name }}
                                </div>
                                <div class="h6 text-secondary">
                                    {{ $file->user->name }}
                                </div>
                            </div>
                            <div class="w-100 d-flex">
                                <button type="button" wire:click="download('{{$file->path}}')"
                                        class="btn w-100 btn-outline-success me-1">
                                    {{ __('Download') }}
                                </button>
                                @can('delete', $file)
                                    <button type="button" class="btn w-100 btn-outline-danger ms-1">
                                        {{ __('Delete') }}
                                    </button>
                                @endcan
                            </div>
                        </div>
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
