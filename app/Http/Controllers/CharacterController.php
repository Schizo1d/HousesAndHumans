<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;

class CharacterController extends Controller
{
    // Отображение списка персонажей
    public function index()
    {
        $characters = Character::where('user_id', auth()->id())->get();
        return view('character_list', compact('characters'));
    }

    // Добавление нового персонажа
    public function store(Request $request)
    {
        // Если имя не передано, используем "Безымянный персонаж"
        $name = $request->input('name', 'Безымянный персонаж');

        $character = Character::create([
            'name' => $name,
            'user_id' => auth()->id(),
        ]);

        return response()->json($character);
    }

    // Удаление персонажа
    public function destroy(Character $character)
    {
        if ($character->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $character->delete();

        return response()->json(['success' => true]);
    }
}
