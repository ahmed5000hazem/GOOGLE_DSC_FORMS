<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    
    public $fillable = ["user_id", "form_id"];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
