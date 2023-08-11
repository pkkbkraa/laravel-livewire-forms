<div>
    <div class="card">
        <div class="card-body">
            @foreach($fields as $field)
                @if($field->view)
                    @include($field->view)
                @else
                    @include('laravel-livewire-forms::fields.' . $field->type)
                @endif
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal" wire:click="closeForm"><i class="ri-close-fill align-bottom"></i> {{ __('Close') }}</button>
            <button class="btn btn-primary btn-sm" wire:click="saveAndStay">{{ __('Save') }}</button>
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
                })
            });
            Livewire.hook('message.processed', (message, component) => {livewire.emit('file-upload')})
        });
    </script>
@endpush
