<div style="background-color: {{ $cardColor }}"
     class="d-flex align-items-center p-3 rounded justify-content-between">
    <div class="d-flex align-items-center">
        <img class="me-3" width="48px" height="48px" src="{{ asset($serviceLogo) }}" alt="{{ $serviceName }} logo">
        <div>
            <h5 class="fw-bold mb-0">{{ __($serviceName) }}</h5>
            <span>{{ __($serviceDescription) }}</span>
        </div>
    </div>
    <div>
        @if($isLinked)
            <button class="btn btn-danger text-light">{{ __('Unlink') }}</button>
        @else
            <a class="btn btn-light" href="{{ $serviceAuthorizationLink }}">{{ __('Link') }}</a>
        @endif
    </div>
</div>
