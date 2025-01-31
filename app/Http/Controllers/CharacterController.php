<?php

// app/Http/Controllers/CharacterController.php
namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function index()
    {
        // Загружаем персонажей текущего пользователя
        $characters = Auth::user()->characters;
        return view('character_list', compact('characters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Создаём персонажа для текущего пользователя
        $character = new Character();
        $character->name = $request->name;
        $character->user_id = Auth::id(); // Привязываем персонажа к текущему пользователю
        $character->save();

        return response()->json($character);
    }

    public function destroy(Character $character)
    {
        // Проверяем, что персонаж принадлежит текущему пользователю
        if ($character->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $character->delete();
        return response()->json(['success' => 'Character deleted']);
    }
}
