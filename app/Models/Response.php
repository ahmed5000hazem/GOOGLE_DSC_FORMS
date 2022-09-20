<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
class Response extends Model
{
    use HasFactory;
    public $fillable = ["question_id", "response_text", "user_id"];

    public function options()
    {
        return $this->belongsToMany(Option::class, "option_response");
    }

}
