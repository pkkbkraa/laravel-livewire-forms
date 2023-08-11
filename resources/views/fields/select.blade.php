<div class="form-group mb-2" wire:ignore>
    <label for="{{ $field->name }}" class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </label>

    <select
        id="{{ $field->name }}"
        class="form-select @error($field->key) is-invalid @enderror"
        data-choices data-choices-removeItem 
        wire:model.lazy="{{ $field->key }}">

        <option value="" disabled selected>{{ $field->placeholder }}</option>

        @foreach($field->options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

</div>
@include('laravel-livewire-forms::fields.error-help')

@push('scripts')
<script>
    @php
    $key = uniqid();
    @endphp
    const {{ $field->name.$key }} = document.getElementById('{{ $field->name }}');
    if (!{{ $field->name.$key }}.classList.contains('choices')) {
        const {{ $field->name.$key }} = new Choices({{ $field->name.$key }});
        {{ $field->name.$key }}.passedElement.element.addEventListener(
            'addItem',
            function(event) {
                @this.set('{{$field->key}}', event.detail.value);
            },
            false
        );
    }
</script>
@endpush
