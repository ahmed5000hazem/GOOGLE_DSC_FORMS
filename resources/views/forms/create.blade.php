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
                <div class="auth-option my-3">
                    @component('components.dynamic-form.radio')
                    @slot('name', "auth")
                    @slot('id', "required_auth")
                    @slot('attributes', 'checked')
                    @slot('labelClasses', 'text-primary')
                    @slot('value', "1")
                    @slot('label', "required auth")
                    @endcomponent
                    
                    @component('components.dynamic-form.radio')
                    @slot('name', 'auth')
                    @slot('id', "optional_auth")
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
                    @slot('value', "0")
                    @slot('label', 'single submit')
                    @endcomponent

                    @component('components.dynamic-form.radio')
                    @slot('name', "multi_submit")
                    @slot('id', "multi_submit")
                    @slot('labelClasses', 'text-primary')
                    @slot('value', "1")
                    @slot('label', "multi submit")
                    @endcomponent
                </div>

                @component('components.dynamic-form.text-area')
                @slot('label', 'Form description')
                @slot('name', 'description')
                @endcomponent
                
                @component('components.dynamic-form.btn')@endcomponent
            </div>
        </div>
    </form>
@endsection