<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    public function register_form()
    {
        return view("auth.register");
    }

    public function login_form()
    {
        $previous_url = str_replace(env("APP_URL") , "", url()->previous());
        if (str_contains($previous_url, "forms")) {
            $exploded = explode("/", $previous_url);
            $form_id = $exploded[count($exploded)-1];
            session(["form_id" => $form_id]);
        }
        return view("auth.login");
    }
    
    public function register(Request $request){
        $request->validate([
            "email" => "required|unique:users,email",
            "password" => "required|confirmed",
        ]);

        $name = explode("@", $request->email);
        $user = User::create([
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "name" => $name[0]
        ]);
        $role = Role::where("name", "normal-user")->first();
        $user->attachRole($role->id);

        return redirect()->route("login");

    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|exists:users,email",
            "password" => "required",
        ]);

        if (Auth::attempt($request->only("email", "password"), $request->remember_me? true: false)){
            
            if((auth()->user())->hasRole("owner")){
                if (session("form_id")) {
                    $id = session("form_id");
                    session()->forget("form_id");
                    return redirect()->route("get_form", ["id" => $id]);
                }
                return redirect()->route("dashboard");
            } else {
                if (session("form_id")) {
                    $id = session("form_id");
                    session()->forget("form_id");
                    return redirect()->route("get_form", ["id" => $id]);
                }
                return view("get-form-error", ["message" => "logged in successfully"]);
            }
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
