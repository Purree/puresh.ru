<div class="position-absolute top-50 start-50 translate-middle">
    @if(!empty($token_validation_errors))
        <div class="alert alert-danger" role="alert">
            <div class="fw-bold">
                {{ __("An error occurred while linking your account, please try again later, if this error occurs again, contact your administrator.") }}
                {{ __("Error message") }}:
            </div>
            @foreach($token_validation_errors as $error)
                <div>
                    {{ __($error) }}
                </div>
            @endforeach
        </div>
    @else
        <div>
            <div class="alert alert-success" role="alert">
                {{ __("Your account has been successfully linked.") }}
            </div>
        </div>
    @endif
    <div class="alert alert-info">
        {{ __('You can close this page. It will automatically close after 10 seconds.') }}
    </div>
</div>
