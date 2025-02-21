<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterAttribute;
use Illuminate\Http\Request;

class CharacterAttributeController extends Controller
{
    public function store(Request $request, Character $character)
    {
        // Валидация атрибутов и навыков
        $request->validate([
            'strength' => 'required|integer|min:1|max:30',
            'dexterity' => 'required|integer|min:1|max:30',
            'constitution' => 'required|integer|min:1|max:30',
            'intelligence' => 'required|integer|min:1|max:30',
            'wisdom' => 'required|integer|min:1|max:30',
            'charisma' => 'required|integer|min:1|max:30',
            // Навыки
            'athletics' => 'nullable|integer|min:-9|max:100',
            'acrobatics' => 'nullable|integer|min:-9|max:100',
            'sleight_of_hand' => 'nullable|integer|min:-9|max:100',
            'stealth' => 'nullable|integer|min:-9|max:100',
            'investigation' => 'nullable|integer|min:-9|max:100',
            'history' => 'nullable|integer|min:-9|max:100',
            'arcana' => 'nullable|integer|min:-9|max:100',
            'nature' => 'nullable|integer|min:-9|max:100',
            'religion' => 'nullable|integer|min:-9|max:100',
            'perception' => 'nullable|integer|min:-9|max:100',
            'survival' => 'nullable|integer|min:-9|max:100',
            'medicine' => 'nullable|integer|min:-9|max:100',
            'insight' => 'nullable|integer|min:-9|max:100',
            'animal_handling' => 'nullable|integer|min:-9|max:100',
            'performance' => 'nullable|integer|min:-9|max:100',
            'intimidation' => 'nullable|integer|min:-9|max:100',
            'deception' => 'nullable|integer|min:-9|max:100',
            'persuasion' => 'nullable|integer|min:-9|max:100',
        ]);

        // Сохранение атрибутов
        $attributes = [
            'strength' => $request->input('strength'),
            'dexterity' => $request->input('dexterity'),
            'constitution' => $request->input('constitution'),
            'intelligence' => $request->input('intelligence'),
            'wisdom' => $request->input('wisdom'),
            'charisma' => $request->input('charisma'),
        ];

        // Обновление или создание атрибутов персонажа
        foreach ($attributes as $key => $value) {
            $character->attributes()->updateOrCreate(
                ['character_id' => $character->id, 'name' => $key],
                ['value' => $value]
            );
        }

        // Сохранение навыков
        $skills = [
            'athletics', 'acrobatics', 'sleight_of_hand', 'stealth', 'investigation', 'history',
            'arcana', 'nature', 'religion', 'perception', 'survival', 'medicine', 'insight',
            'animal_handling', 'performance', 'intimidation', 'deception', 'persuasion'
        ];

        foreach ($skills as $skill) {
            $value = $request->input($skill);
            $character->attributes()->updateOrCreate(
                ['character_id' => $character->id, 'name' => $skill],
                ['value' => $value]
            );
        }

        // Перенаправление на страницу с информацией о персонаже
        return redirect()->route('character_list')->with('success', 'Атрибуты и навыки успешно обновлены!');
    }
}

