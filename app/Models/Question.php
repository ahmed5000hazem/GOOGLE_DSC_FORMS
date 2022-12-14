<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\Option;
use App\Models\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ["form_id", "question_text", "question_type", "visible", "required", "order"];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function scopeVisible($query)
    {
        $query->where('visible', 1);
    }
    
    public function scopeHidden($query)
    {
        $query->where('visible', 0);
    }
}
