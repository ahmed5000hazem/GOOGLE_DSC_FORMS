@extends('layouts.app')
@section('content')
    <h2 class="text-center my-4">create form</h2>
    <form action="{{route("forms.store")}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-8 col-lg-4">
                @component('components.dynamic-form.input')
                @slot('label', 'Form name')
                @slot('name', 'name')
                @endcomponent
                
                @component('components.dynamic-form.input-date-time')
                @slot('label', 'Expiration date')
                @slot('name', 'expires_at')
                @endcomponent

                @component('components.dynamic-form.text-area')
                @slot('label', 'Form description')
                @slot('name', 'description')
                @endcomponent
                
                @component('components.dynamic-form.btn')@endcomponent
            </div>
        </div>
    </form>
@endsection