<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $forms = Form::where("owner_id", auth()->user()->id)->get();
        return view("dashboard", ["forms" => $forms]);
    }
}
