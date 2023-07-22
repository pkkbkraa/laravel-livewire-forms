<div class="col-md{{ $array_field->column_width ? '-' . $array_field->column_width : '' }} mb-2" wire:ignore>
    <select
        class="form-control @error($field->key . '.' . $key . '.' . $array_field->name) is-invalid @enderror" 
        data-choices data-choices-removeItem multiple 
        wire:model.lazy="{{ $field->key . '.' . $key . '.' . $array_field->name }}">

        <option value="">{{ $array_field->placeholder }}</option>

        @foreach($array_field->options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @include('laravel-livewire-forms::array-fields.error-help')
</div>

@push('scripts')
<script>
    const choices = new Choices(document.getElementById('{{ $field->name }}'));
    const values = choices.getValue(true);
    choices.passedElement.element.addEventListener(
        'addItem',
        function(event) {
            values.push(event.detail.value);

            @this.set('{{$field->key}}', values);
        },
        false,
    );
    choices.passedElement.element.addEventListener(
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
