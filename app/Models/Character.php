<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'race',
        'class',
        'subclass',
        'level',
        'experience',
        'user_id'
    ];
    public function attributes()
    {
        return $this->hasOne(CharacterAttribute::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
