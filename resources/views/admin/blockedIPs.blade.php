<x-admin-panel>
    <div class="card">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $message }}</div>
        @endif


        <div class="m-1">
            <livewire:admin.ban-ip wire:key="{{ uniqid(more_entropy: true) }}"></livewire:admin.ban-ip>
        </div>

        <div class="ms-0 me-0 row bg-dark table-dark">
            <div class="col">{{ __('IPs') }}</div>
            <div class="col">{{ __('Actions') }}</div>
        </div>

        @forelse($blockedIPs as $blockedIP)
            <div class="ms-0 me-0 row bg-dark py-1 table-dark">
                <div class="col">
                    {{ $blockedIP['ip'] }}
                </div>
                <div class="col">
                    <livewire:admin.delete-ip wire:key="{{$blockedIP->id}}" :ip="$blockedIP"
                                              :page="request()->fullUrl()"/>
                </div>
            </div>
        @empty
            <div>Пока пусто</div>
        @endforelse

        {{ $blockedIPs->onEachSide(1)->links() }}
    </div>
</x-admin-panel>
