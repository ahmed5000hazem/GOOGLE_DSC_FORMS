@extends("layouts.app")
@section("content")
    <div class="container">
        <div class="row mt-5">
            <div class="col-4 col-md-2 ">
                @component("components.form-widget")
                @slot("title", 'Create a Blank Form')
                @slot("href", route("forms.create"))
                @slot("content", "<svg xmlns='http://www.w3.org/2000/svg' width='90' height='90' fill='currentColor' class='bi bi-plus-lg' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z'/>
                        </svg>")
                @endcomponent
            </div>
            @foreach ($forms as $form)
                <div class="col-4 col-md-2 ">
                    @component("components.form-widget")
                        @slot("title", $form->description)
                        @slot("href", route("forms.edit", ["id" => $form->id] ))
                        @slot("content", $form->name)
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>
@endsection