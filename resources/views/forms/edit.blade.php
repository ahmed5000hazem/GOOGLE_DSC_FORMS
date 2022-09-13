@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="text-center my-4">edit form</h2>
    <div class="options">
        <a href="{{route("design-form", ["id"=>$form->id])}}" class="btn btn-primary">Design Form</a>
    </div>
    <form action="{{route('forms.update', ['id' => $form->id])}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-8 col-lg-4">
                @component('components.dynamic-form.input')
                    @slot('label', 'Form name')
                    @slot('name', 'name')
                    @slot('value', $form->name)
                @endcomponent
                
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