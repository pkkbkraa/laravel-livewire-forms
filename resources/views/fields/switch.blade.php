<div class="form-group mb-2">
    <label for="{{ $field->name }}" class="form-label">
        {{ $field->placeholder ? $field->label : '' }} {!! strpos($field->rules, 'accepted') !== false ? '<font color="red">*</font>' : '' !!}
    </label>

    <div class="form-check form-switch form-switch-md">
        <input
            id="{{ $field->name }}"
            type="checkbox"
            class="form-check-input @error($field->key) is-invalid @enderror"
            wire:model.lazy="{{ $field->key }}">

        <label class="form-check-label" for="{{ $field->name }}">
            {{ $field->placeholder ?? $field->label }}
        </label>
    </div>

    @include('laravel-livewire-forms::fields.error-help')
</div>
