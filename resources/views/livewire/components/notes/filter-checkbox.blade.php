<div class="form-check form-check-inline">
    <input class="form-check-input noteFilterCheckbox" type="checkbox" value="{{ $filterValue }}"
           id="{{ $filterName }}"
           {{ in_array($filterValue, $filters, true) ? 'checked' : '' }} name="filters[]">
    <label class="form-check-label" for="{{ $filterName }}">
        {{ __($filterText) }}
    </label>
</div>
