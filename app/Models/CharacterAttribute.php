<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterAttribute extends Model
{
    protected $fillable = [
        'character_id',
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
