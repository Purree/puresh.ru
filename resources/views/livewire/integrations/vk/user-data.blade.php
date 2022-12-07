<div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @else
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <img width="70px" height="70px" class="rounded-circle cursor-pointer"
                         onclick="window.open('{{ $photoMaxSize }}', '_blank').focus()"
                         src="{{ $photo }}" alt="vk profile avatar"/>
                </div>
                <div>
                    <h5 class="card-title">{{ $name }} {{ $nickname }} {{ $surname }} ({{ $maidenName }})</h5>
                    <a class="link" href="https://vk.com/{{ $domain }}">https://vk.com/{{ $domain }}</a>
                    <div>ID: {{ $userId }}</div>
                </div>
            </div>
        </div>
    @endif
</div>
