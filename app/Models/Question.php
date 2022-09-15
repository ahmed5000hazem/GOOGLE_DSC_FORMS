<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Option;

class Question extends Model
{
    use HasFactory;
    public $fillable = ["form_id", "question_text", "question_type"];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
