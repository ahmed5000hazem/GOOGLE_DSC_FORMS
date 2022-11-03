<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    
    public $fillable = ["user_id", "form_id", "token"];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
