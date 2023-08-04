<div class="form-group mb-2">
    <label for="{{ $field->name }}" class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </label>

    <input
        id="{{ $field->name }}"
        type="text"
        class="form-control @error($field->key) is-invalid @enderror"
        autocomplete="{{ $field->autocomplete }}"
        placeholder="{{ $field->placeholder }}"
        data-provider="flatpickr"
        data-date-format="{{ $field->format ?? 'Y-m-d' }}"
        data-deafult-date="{{ $field->deafult }}"
        data-range-date="{{ $field->range ?? 'false' }}"
        wire:model.lazy="{{ $field->key }}">

    @include('laravel-livewire-forms::fields.error-help')
</div>
