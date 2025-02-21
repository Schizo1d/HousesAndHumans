<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterAttribute;
use Illuminate\Http\Request;

class CharacterAttributeController extends Controller
{
    public function store(Request $request, Character $character)
    {
        $request->validate([
            'strength' => 'required|integer|min:1|max:30',
            'dexterity' => 'required|integer|min:1|max:30',
            'constitution' => 'required|integer|min:1|max:30',
            'intelligence' => 'required|integer|min:1|max:30',
            'wisdom' => 'required|integer|min:1|max:30',
            'charisma' => 'required|integer|min:1|max:30',

            // Навыки теперь без ограничений
            'athletics' => 'nullable|integer',
            'acrobatics' => 'nullable|integer',
            'sleight_of_hand' => 'nullable|integer',
            'stealth' => 'nullable|integer',
            'investigation' => 'nullable|integer',
            'history' => 'nullable|integer',
            'arcana' => 'nullable|integer',
            'nature' => 'nullable|integer',
            'religion' => 'nullable|integer',
            'perception' => 'nullable|integer',
            'survival' => 'nullable|integer',
            'medicine' => 'nullable|integer',
            'insight' => 'nullable|integer',
            'animal_handling' => 'nullable|integer',
            'performance' => 'nullable|integer',
            'intimidation' => 'nullable|integer',
            'deception' => 'nullable|integer',
            'persuasion' => 'nullable|integer',
        ]);

        // Сохраняем все атрибуты
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

        return redirect()->route('character_info', ['id' => $character->id])
            ->with('success', 'Атрибуты успешно сохранены!');
    }

    public function edit(Character $character)
    {
        return view('character_attributes', compact('character'));
    }
}
