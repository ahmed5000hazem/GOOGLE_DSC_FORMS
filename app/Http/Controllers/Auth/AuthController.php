<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login_form()
    {
        return view("auth.login");
    }
    
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|exists:users,email",
            "password" => "required",
        ]);
        
        if (Auth::attempt($request->only("email", "password"))){
            return redirect()->route("dashboard");
        }
        
        return redirect()->back();
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route("login");
    }
}
