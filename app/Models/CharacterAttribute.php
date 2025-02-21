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
        'athletics',         // Атлетика
        'acrobatics',        // Акробатика
        'sleight_of_hand',   // Ловкость рук
        'stealth',           // Скрытность
        'investigation',     // Анализ
        'history',           // История
        'arcana',            // Магия
        'nature',            // Природа
        'religion',          // Религия
        'perception',        // Восприятие
        'survival',          // Выживание
        'medicine',          // Медицина
        'insight',           // Проницательность
        'animal_handling',   // Уход за животными
        'performance',       // Выступление
        'intimidation',      // Запугивание
        'deception',         // Обман
        'persuasion',        // Убеждение
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
