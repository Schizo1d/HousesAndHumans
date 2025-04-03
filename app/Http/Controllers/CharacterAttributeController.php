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
        ]);

        // Сохраняем атрибуты и навыки
        $attributes = CharacterAttribute::updateOrCreate(
            ['character_id' => $character->id],
            $request->only([
                'strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma',
                'athletics', 'acrobatics', 'sleight_of_hand', 'stealth',
                'investigation', 'history', 'arcana', 'nature', 'religion',
                'perception', 'survival', 'medicine', 'insight', 'animal_handling',
                'performance', 'intimidation', 'deception', 'persuasion'
            ])
        );

        // Перенаправление с успешным сообщением
        return redirect()->route('character_info', ['id' => $character->id])
            ->with('success', 'Атрибуты и навыки успешно сохранены!');
    }
    public function updateSkill(Request $request)
    {
        $character = Character::find($request->character_id);
        if (!$character) {
            return response()->json(['success' => false, 'error' => 'Персонаж не найден']);
        }

        // Обновляем навык
        $character->skills[$request->skill] = $request->value;
        $character->save();

        return response()->json(['success' => true]);
    }
    public function edit(Character $character)
    {
        return view('character_attributes', compact('character'));
    }
}
