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
                <h2 class="mb-3 text-center text-primary fw-bold">Register DSC Forms</h2>
                <div class="my-3">
                    <strong>
                        Have An Account ? <a href="{{route("login_form")}}" class="text-decoration-none text-warning "> Login Instead.</a>
                    </strong>
                </div>
                <form action="{{route("register")}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="login_input" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="login_input" name="email" value="{{old("email")}}" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="reg_password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="reg_password">
                    </div>
                    <div class="mb-3">
                        <label for="reg_password_confirm" class="form-label">Password Confirmation</label>
                        <input type="password" class="form-control" name="password_confirmation" id="reg_password_confirm">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection