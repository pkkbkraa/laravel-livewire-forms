<div>
    <div class="form-group mb-2" wire:ignore>
        <label for="{{ $field->name }}" class="form-label">
            {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
        </label>

        <select
            id="{{ $field->name }}"
            class="form-control" 
            multiple="multiple"
            wire:model.lazy="{{ $field->key }}">

            @foreach($field->options as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>
    @include('laravel-livewire-forms::fields.error-help')
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
        Livewire.hook('message.processed', (message, component) => {
            multi(select_element, {
                enable_search: true,
                search_placeholder: '{{__('filter')}}',
                "non_selected_header": null,
                "selected_header": null,
                "limit": -1,
                "limit_reached": function () {},
                "hide_empty_groups": false,
            });
        })
    </script>
@endpush
