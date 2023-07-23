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
                            <div class="row gallery-wrapper">
                                <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" data-category="designing development">
                                    <div class="gallery-box card">
                                        <div class="gallery-container">
                                            <a class="image-popup" href="{{ $value->temporaryUrl() }}" title="">
                                                <img class="gallery-img img-fluid mx-auto" src="{{ $value->temporaryUrl() }}" alt="" />
                                                <div class="gallery-overlay">
                                                    <h5 class="overlay-caption">{{ $value->getFilename() }}</h5>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@push('styles')
    <!-- glightbox css -->
    <link href="{{ URL::asset('s/'.CSSJS_Ver.'/assets/libs/glightbox/css/glightbox.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <!-- glightbox js -->
    <script src="{{ URL::asset('s/'.CSSJS_Ver.'/assets/libs/glightbox/js/glightbox.min.js') }}"></script>
    <!-- isotope-layout -->
    <script src="{{ URL::asset('s/'.CSSJS_Ver.'/assets/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>
    
    <script>
    window.livewire.on('file-update', () => {
        document.addEventListener("DOMContentLoaded",function(e){document.querySelector(".gallery-wrapper")&&(t=new Isotope(".gallery-wrapper",{itemSelector:".element-item",layoutMode:"fitRows"}));var t,r=document.querySelector(".categories-filter"),r=(r&&r.addEventListener("click",function(e){matchesSelector(e.target,"li a")&&(e=e.target.getAttribute("data-filter"))&&t.arrange({filter:e})}),document.querySelectorAll(".categories-filter"));r&&Array.from(r).forEach(function(e){var t;(t=e).addEventListener("click",function(e){matchesSelector(e.target,"li a")&&(t.querySelector(".active").classList.remove("active"),e.target.classList.add("active"))})})});var lightbox=GLightbox({selector:".image-popup",title:!1});
    });
    </script>
@endpush
