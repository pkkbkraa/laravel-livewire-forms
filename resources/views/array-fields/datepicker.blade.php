<div class="col-md{{ $array_field->column_width ? '-' . $array_field->column_width : '' }} mb-2">
    <input
        type="text"
        class="form-control form-control-sm @error($field->key . '.' . $key . '.' . $array_field->name) is-invalid @enderror"
        autocomplete="{{ $array_field->autocomplete }}"
        placeholder="{{ $array_field->placeholder }}"
        data-provider="flatpickr"
        data-date-format="{{ $array_field->format ?? 'Y-m-d' }}"
        data-deafult-date="{{ $array_field->deafult }}"
        data-range-date="{{ $array_field->range ?? 'false' }}"
        wire:model.lazy="{{ $field->key . '.' . $key . '.' . $array_field->name }}">

    @include('laravel-livewire-forms::array-fields.error-help')
</div>
