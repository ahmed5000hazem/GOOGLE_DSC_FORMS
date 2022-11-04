<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Question;
use App\Scopes\UserFormScope;

class Form extends Model
{
    use HasFactory;
    protected $fillable = ["name", "owner_id", "description", "expires_at", "auth", "multi_submit"];

    public function questions()
    {
        return $this->hasMany(Question::class, 'form_id', 'id');
    }

    public function options()
    {
        return $this->hasManyThrough(Option::class, Question::class);
    }

    public function responses()
    {
        return $this->hasManyThrough(Response::class, Submission::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserFormScope);
    }
}
