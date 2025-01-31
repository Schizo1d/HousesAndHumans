<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterAttributeController extends Controller
{
    public function store(Request $request, $characterId)
    {
        $request->validate([
            'strength' => 'required|integer',
            'dexterity' => 'required|integer',
            'constitution' => 'required|integer',
            'intelligence' => 'required|integer',
            'wisdom' => 'required|integer',
            'charisma' => 'required|integer',
        ]);

        // Находим персонажа
        $character = Character::findOrFail($characterId);

        // Создаем атрибуты для этого персонажа
        $attributes = CharacterAttribute::updateOrCreate(
            ['character_id' => $character->id], // Привязываем к конкретному персонажу
            $request->only(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'])
        );

        return response()->json($attributes);
    }

}
