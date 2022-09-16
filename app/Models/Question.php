<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\Option;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ["form_id", "question_text", "question_type", "visible", "order"];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
