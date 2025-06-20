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
            'passive_perception' => 'required|integer|min:1|max:30',
            'passive_insight' => 'required|integer|min:1|max:30',
            'passive_investigation' => 'required|integer|min:1|max:30',
            'exhaustion' => 'required|integer|min:0|max:6',
        ]);
        // Сохраняем атрибуты и навыки
        try {
            $character = Character::findOrFail($request->character_id); // Проверка ID
            \Log::info("Сохранение персонажа ID: " . $character->id);

            $attributes = CharacterAttribute::updateOrCreate(
                ['character_id' => $character->id],
                $request->only([
                    'strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma',
                    'athletics', 'acrobatics', 'sleight_of_hand', 'stealth',
                    'investigation', 'history', 'arcana', 'nature', 'religion',
                    'perception', 'survival', 'medicine', 'insight', 'animal_handling',
                    'performance', 'intimidation', 'deception', 'persuasion',
                    'passive_perception', 'passive_insight', 'passive_investigation', 'exhaustion'
                ])
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error("Ошибка при сохранении персонажа: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function edit(Character $character)
    {
        $level = $character->level ?? 1;
        $proficiencyBonus = floor(($level + 7) / 4); // Стандартная формула D&D 5e

        return view('character_attributes', [
            'character' => $character,
            'proficiencyBonus' => $proficiencyBonus, // Убедитесь, что передаете переменную
        ]);
    }
}
