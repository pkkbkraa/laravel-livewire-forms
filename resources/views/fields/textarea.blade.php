<div class="form-group mb-2">
    <label for="{{ $field->name }}" class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </label>

    <textarea
        id="{{ $field->name }}"
        rows="{{ $field->textarea_rows }}"
        class="form-control @error($field->key) is-invalid @enderror"
        placeholder="{{ $field->placeholder }}"
        wire:model.lazy="{{ $field->key }}"></textarea>

    @include('laravel-livewire-forms::fields.error-help')
</div>
