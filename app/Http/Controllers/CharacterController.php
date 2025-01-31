<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function index()
    {
        // Проверяем, авторизован ли пользователь
        if (Auth::check()) {
            // Загружаем персонажей текущего пользователя
            $characters = Auth::user()->characters;
            return view('character_list', compact('characters'));
        }

        // Если пользователь не авторизован, редиректим на страницу входа
        return redirect()->route('login')->with('error', 'Вы не авторизованы!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if (Auth::check()) {
            // Создаём персонажа для текущего пользователя
            $character = new Character();
            $character->name = $request->name;
            $character->user_id = Auth::id(); // Привязываем персонажа к текущему пользователю
            $character->save();

            // Создаем атрибуты для нового персонажа
            CharacterAttribute::create([
                'character_id' => $character->id,
                'strength' => 10,
                'dexterity' => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom' => 10,
                'charisma' => 10,
            ]);

            return response()->json($character);
        }

        return response()->json(['error' => 'User is not authenticated.'], 403);
    }

    public function destroy(Character $character)
    {
        // Проверяем, что персонаж принадлежит текущему пользователю
        if (Auth::check() && $character->user_id == Auth::id()) {
            $character->delete();
            return response()->json(['success' => 'Character deleted']);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function edit($id)
    {
        // Получаем персонажа с его атрибутами
        $character = Character::with('attributes')->findOrFail($id);

        // Проверяем, что персонаж принадлежит текущему пользователю
        if (Auth::id() !== $character->user_id) {
            return redirect()->route('character_list')->with('error', 'Вы не можете редактировать этого персонажа.');
        }

        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, $id)
    {
        // Находим персонажа
        $character = Character::findOrFail($id);

        // Проверяем, что персонаж принадлежит текущему пользователю
        if (Auth::id() !== $character->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Валидация данных
        $request->validate([
            'strength' => 'required|integer|min:1|max:20',
            'dexterity' => 'required|integer|min:1|max:20',
            'constitution' => 'required|integer|min:1|max:20',
            'intelligence' => 'required|integer|min:1|max:20',
            'wisdom' => 'required|integer|min:1|max:20',
            'charisma' => 'required|integer|min:1|max:20',
        ]);

        // Обновление или создание атрибутов персонажа
        $character->attributes()->updateOrCreate(
            ['character_id' => $character->id],
            $request->only(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'])
        );

        return redirect()->route('character_list')->with('success', 'Атрибуты успешно обновлены.');
    }
}
