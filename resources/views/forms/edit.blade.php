@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row options my-3">
        <div class="col-4 col-lg-2">
            <a href="{{route("design-form", ["id"=>$form->id])}}" class="btn btn-primary">Design Form</a>
        </div>
        <div class="col-4 col-lg-2">
            <a href="{{route("get-responses", ["id" => $form->id])}}" class="btn btn-info">Responses</a>
        </div>
        <div class="col-4 col-lg-2">
            <a href="{{route("get_form", ["id" => $form->id])}}" target="_blank" class="btn btn-success">Preview</a>
        </div>
    </div>
    <div class="row">
        <div class="col-4 col-lg-4">
            <form action="{{route('import-from-excel', ["id" => $form->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="formFile" class="form-label text-warning bg-dark p-1">import from excel</label>
                    <input class="form-control" type="file" id="formFile" name="form_submissions">
                </div>
                @component('components.dynamic-form.btn')
                    @slot('btn', 'primary')
                    @slot('text', 'Upload')
                    @slot('classes', 'd-block w-100')
                @endcomponent
            </form>
        </div>
    </div>
    <hr>
</div>
<div class="container">
    <h2 class="text-center">edit form</h2>
    <form class="mt-5" action="{{route('forms.update', ['id' => $form->id])}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-8 col-lg-4">
                @component('components.dynamic-form.input')
                    @slot('label', 'Form name')
                    @slot('name', 'name')
                    @slot('value', $form->name)
                @endcomponent
                
                @component('components.dynamic-form.input-date-time')
                @slot('label', 'Expiration date')
                @slot('name', 'expires_at')
                @slot("date", $form->expires_at)
                @endcomponent
                
                <div class="auth-option my-3">
                    @component('components.dynamic-form.radio')
                    @slot('name', "auth")
                    @slot('id', "required_auth")
                    @if ($form->auth)
                        @slot('attributes', 'checked')
                    @endif
                    @slot('labelClasses', 'text-primary')
                    @slot('value', "1")
                    @slot('label', "required auth")
                    @endcomponent
                    
                    @component('components.dynamic-form.radio')
                    @slot('name', 'auth')
                    @slot('id', "optional_auth")
                    @if (!$form->auth)
                        @slot('attributes', 'checked')
                    @endif
                    @slot('labelClasses', 'text-danger')
                    @slot('value', "0")
                    @slot('label', 'optional auth')
                    @endcomponent
                </div>

                <div class="auth-option my-3">
                    @component('components.dynamic-form.radio')
                    @slot('name', 'multi_submit')
                    @slot('id', "single_submit")
                    @slot('labelClasses', 'text-primary')
                    @slot('attributes', 'checked')
                    @if (!$form->multi_submit)
                        @slot('attributes', 'checked')
                    @endif
                    @slot('value', "0")
                    @slot('label', 'single submit')
                    @endcomponent
                    
                    @component('components.dynamic-form.radio')
                    @slot('name', "multi_submit")
                    @slot('id', "multi_submit")
                    @if ($form->multi_submit)
                        @slot('attributes', 'checked')
                    @endif
                    @slot('labelClasses', 'text-primary')
                    @slot('value', "1")
                    @slot('label', "multi submit")
                    @endcomponent
                </div>

                @component('components.dynamic-form.text-area')
                    @slot('label', 'Edit form description')
                    @slot('name', 'description')
                    @slot('value', $form->description)
                @endcomponent
                
                @component('components.dynamic-form.btn')
                    @slot("classes", "d-block w-100")
                @endcomponent
            </div>
            
        </div>
    </form>
    <form action="{{route('forms.delete', ['id' => $form->id])}}" method="post">
        {{-- @method('delete') --}}
        @csrf
        <div class="row justify-content-center">
            <div class="col-8 col-lg-4">
                @component('components.dynamic-form.btn')
                    @slot('btn', 'danger')
                    @slot('text', 'Delete')
                    @slot('classes', 'd-block w-100')
                @endcomponent
            </div>
        </div>
    </form>
</div>
    
@endsection