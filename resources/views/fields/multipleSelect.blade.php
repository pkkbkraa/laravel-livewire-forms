<div class="form-group mb-2" wire:ignore>
    <label for="{{ $field->name }}" class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </label>

    <select
        id="{{ $field->name }}"
        class="form-control @error($field->key) is-invalid @enderror" 
        data-choices data-choices-removeItem multiple 
        wire:model.lazy="{{ $field->key }}">

        <option value="" disabled selected>{{ $field->placeholder }}</option>

        @foreach($field->options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @include('laravel-livewire-forms::fields.error-help')
</div>

@push('scripts')
<script>
    @php
    $key = uniqid();
    @endphp
    const {{'choices'.$key}} = new Choices(document.getElementById('{{ $field->name }}'));
    const values = {{'choices'.$key}}.getValue(true);
    {{'choices'.$key}}.passedElement.element.addEventListener(
        'addItem',
        function(event) {
            values.push(event.detail.value);

            @this.set('{{$field->key}}', values);
        },
        false,
    );
    {{'choices'.$key}}.passedElement.element.addEventListener(
        'removeItem',
        function(event) {
            remove(values, event.detail.value);
            @this.set('{{$field->key}}', values);
        },
        false,
    );
    
    function remove(arr) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax= arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }
</script>
@endpush
