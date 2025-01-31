<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterAttributeController extends Controller
{
    public function store(Request $request, Character $character)
    {
        $request->validate([
            'strength' => 'required|integer',
            'dexterity' => 'required|integer',
            'constitution' => 'required|integer',
            'intelligence' => 'required|integer',
            'wisdom' => 'required|integer',
            'charisma' => 'required|integer',
        ]);

        // Создаём или обновляем атрибуты для персонажа
        $attributes = CharacterAttribute::updateOrCreate(
            ['character_id' => $character->id],
            $request->only(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'])
        );

        return response()->json($attributes);
    }


    public function edit(Character $character)
    {
        return view('character_attributes', compact('character'));
    }
}
