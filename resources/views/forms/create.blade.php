@extends('layouts.app')
@section('content')
    <h2 class="text-center my-4">create form</h2>
    <form action="{{route("forms.store")}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-8 col-lg-4">
                @component('components.dynamic-form.input')
                @slot('label', 'form name')
                @slot('name', 'name')
                @endcomponent
                
                @component('components.dynamic-form.text-area')
                @slot('label', 'enter form description')
                @slot('name', 'description')
                @endcomponent
                
                @component('components.dynamic-form.btn')@endcomponent
            </div>

        </div>
    </form>
@endsection