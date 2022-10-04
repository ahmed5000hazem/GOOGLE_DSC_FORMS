@extends('layouts.app')
@section('content')
    <div class="container login-page">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
                @if ($errors->any())
                    @foreach ($errors->all() as $err)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$err}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
                <h2 class="mb-3 text-center text-primary fw-bold">Login DSC Forms</h2>
                <div class="my-3">
                    <strong>
                        Be A Member <a href="{{route("register_form")}}" class="text-decoration-none text-warning ">Register</a>
                    </strong>
                </div>
                <form action="{{route("login")}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="login_input" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="login_input" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="login_password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="login_password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember_me" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection