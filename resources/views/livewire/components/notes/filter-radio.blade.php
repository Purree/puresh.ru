<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="{{ $filterName }}"
           value="{{ $filterValue }}" name="orderFilter" {{ $filterOrder === $filterValue ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $filterName }}">
        {{ __($filterText) }}
    </label>
</div>
