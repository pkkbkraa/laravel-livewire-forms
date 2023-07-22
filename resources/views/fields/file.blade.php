<div class="form-group mb-2">
    <label for="{{ $field->name }}" class="form-label">
        {{ $field->label }} {!! strpos($field->rules, 'required') !== false ? '<font color="red">*</font>' : '' !!}
    </label>

    <div class="custom-file">
        <input
            id="{{ $field->name }}"
            type="file"
            class="form-control @error($field->key) is-invalid @enderror"
            wire:model="{{ $field->key }}"
            {{ $field->file_multiple ? 'multiple' : '' }}>

        <label class="custom-file-label" for="{{ $field->name }}">
            {{ $field->placeholder }}
        </label>
    </div>

    @if($form_data[$field->name])
        <ul class="list-group mt-2">
            @foreach($form_data[$field->name] ?? [] as $key => $value)
                <li class="list-group-item p-2">
                    <div class="row align-items-center">
                        <div class="col">
                            <a href="{{ $value->temporaryUrl() }}" target="_blank">
                                <i class="fa fa-fw mr-1"></i>{{ $value->getFilename() }}
                            </a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-danger"
                                    wire:click="confirm('{{ $field->name }}', '{{ $key }}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @include('laravel-livewire-forms::fields.error-help')
</div>
