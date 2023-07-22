<div>
    <div class="{{$type == 'modal' ? '' : 'card'}}">
        <div class="{{$type == 'modal' ? '' : 'card'}}-body">
            @foreach($fields as $field)
                @if($field->view)
                    @include($field->view)
                @else
                    @include('laravel-livewire-forms::fields.' . $field->type)
                @endif
            @endforeach
        </div>
        <div class="{{$type == 'modal' ? '' : 'card'}}-footer">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal" wire:click="closeForm"><i class="ri-close-fill align-bottom"></i> {{ __('Close') }}</button>
                <button class="btn btn-primary btn-sm" wire:click="saveAndStay">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Code is inspired by Pastor Ryan Hayden
        // https://github.com/livewire/livewire/issues/106
        // Thank you, sir!
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="file"]').forEach(file => {
                file.addEventListener('input', event => {
                    let form_data = new FormData();
                    form_data.append('component', @json(get_class($this)));
                    form_data.append('field_name', file.id);

                    for (let i = 0; i < event.target.files.length; i++) {
                        form_data.append('files[]', event.target.files[i]);
                    }

                    axios.post('{{ route('laravel-livewire-forms.file-upload') }}', form_data, {
                        headers: {'Content-Type': 'multipart/form-data'}
                    }).then(response => {
                        window.livewire.emit('fileUpdate', response.data.field_name, response.data.uploaded_files);
                    });
                })
            });
        });
    </script>
@endpush
