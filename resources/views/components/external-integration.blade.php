<div style="background-color: {{ $cardColor }}"
     class="d-flex align-items-center p-3 rounded justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center">
        <img class="me-3" width="48px" height="48px" src="{{ asset($serviceLogo) }}" alt="{{ $serviceLogo }} logo">
        <div>
            {{ $serviceData }}
        </div>
    </div>
    <div class="col-12 col-sm-3 col-lg-2">
        {{ $serviceLinking }}
    </div>
</div>
