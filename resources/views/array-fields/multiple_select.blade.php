<div class="col-md{{ $array_field->column_width ? '-' . $array_field->column_width : '' }} mb-2" wire:ignore>
    <select
        class="form-control @error($field->key . '.' . $key . '.' . $array_field->name) is-invalid @enderror" 
        multiple="multiple" 
        wire:model.lazy="{{ $field->key . '.' . $key . '.' . $array_field->name }}">

        <option value="">{{ $array_field->placeholder }}</option>

        @foreach($array_field->options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @include('laravel-livewire-forms::array-fields.error-help')
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/multi.js/0.2.4/multi.min.css" />
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/multi.js/0.2.4/multi.min.js"></script>
    <script>
        var select_element = document.getElementById("{{ $field->name }}");
        multi(select_element, {
            enable_search: true,
            search_placeholder: '{{__('filter')}}',
            "non_selected_header": null,
            "selected_header": null,
            "limit": -1,
            "limit_reached": function () {},
            "hide_empty_groups": false,
        });
    </script>
@endpush

