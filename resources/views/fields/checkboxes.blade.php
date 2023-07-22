<div class="form-group mb-2">
    <div class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </div>

    @foreach($field->options as $value => $label)
        <div class="form-check">
            <input
                id="{{ $field->name . '.' . $loop->index }}"
                type="checkbox"
                class="form-check-input @error($field->key) is-invalid @enderror"
                value="{{ $value }}"
                wire:model.lazy="{{ $field->key }}">

            <label class="form-check-label" for="{{ $field->name . '.' . $loop->index }}">
                {{ $label }}
            </label>
        </div>
    @endforeach

    @include('laravel-livewire-forms::fields.error-help')
</div>
