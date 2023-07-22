<div class="form-group  mb-2">
    <div class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </div>

    @if(isset($form_data[$field->name]) && $form_data[$field->name])
        <ul class="list-group mb-2">
            @foreach($form_data[$field->name] as $key => $value)
                <div class="list-group-item list-group-item-action p-2">
                    <div class="form-row">
                        @foreach($field->array_fields as $array_field)
                            @include('laravel-livewire-forms::array-fields.' . $array_field->type)
                        @endforeach
                        <div class="col-md-auto">
                            @if($field->array_sortable)
                                <button class="btn btn-sm btn-primary" wire:click="arrayMoveUp('{{ $field->name }}', '{{ $key }}')">
                                    <i class="bx bx-chevron-up"></i>
                                </button>

                                <button class="btn btn-sm btn-primary" wire:click="arrayMoveDown('{{ $field->name }}', '{{ $key }}')">
                                    <i class="bx bx-chevron-down"></i>
                                </button>
                            @endif

                            <button class="btn btn-sm btn-danger"
                                    wire:click="confirm('{{ $field->name }}', '{{ $key }}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    @endif

    <button class="btn btn-primary btn-sm mb-2" wire:click="arrayAdd('{{ $field->name }}')">
        Add {{ Str::singular($field->label) }}
    </button>

    @include('laravel-livewire-forms::fields.error-help')
</div>
