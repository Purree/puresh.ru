<div style="background-color: {{ $cardColor }}"
     class="d-flex align-items-center p-3 rounded justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center">
        <img class="me-3" width="48px" height="48px" src="{{ asset($serviceLogo) }}" alt="{{ $serviceName }} logo">
        <div>
            <h5 class="fw-bold mb-0">{{ __($serviceName) }}</h5>
            <span>{{ $serviceDescription }}</span>
        </div>
    </div>
    <div class="col-12 col-sm-3 col-lg-2">
        {{ $serviceLinking }}
    </div>
</div>
