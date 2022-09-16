<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Question;

class Form extends Model
{
    use HasFactory;
    protected $fillable = ["name", "owner_id", "description"];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
