<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        return view("forms.edit", ["form" => $form]);
    }
    public function create()
    {
        return view("forms.create");
    }

    public function store(Request $request)
    {
        $request->validate(["name" => "required"]);

        Form::create([
            "name" => $request->name,
            "description" => $request->description,
            "owner_id" => auth()->user()->id,
        ]);

        return redirect()->route("dashboard");
    }
    public function update(Request $request, $id)
    {
        $request->validate(["name" => "required"]);

        $form = Form::findOrFail($id);
        $form->update($request->only("name", "description"));
        
        return redirect()->route("dashboard");
    }

    public function delete($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
        return redirect()->route("dashboard");
    }
}
