<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function show($id)
    {
        // Находим персонажа с его атрибутами
        $character = Character::with('attributes')->find($id);

        if (!$character) {
            return redirect()->route('main')->with('error', 'Персонаж не найден.');
        }

        return view('character_info', compact('character'));
    }
    public function index()
    {
        // Проверяем, авторизован ли пользователь
        if (Auth::check()) {
            // Загружаем персонажей текущего пользователя
            $characters = Auth::user()->characters;
            return view('character_list', compact('characters'));
        }

        // Если пользователь не авторизован, редиректим на страницу входа
        return redirect('/character_list')->with('success', 'Атрибуты успешно сохранены!');
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

            return response()->json($character);
        }

        return response()->json(['error' => 'User is not authenticated.'], 403);
    }

    public function updateName(Request $request)
    {
        // Проверяем, что пользователь авторизован
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Пользователь не авторизован'], 401);
        }

        // Проверяем, что передан корректный идентификатор персонажа
        $character = $user->characters()->find($request->character_id);
        if (!$character) {
            return response()->json(['success' => false, 'error' => 'Персонаж не найден для данного пользователя'], 404);
        }

        // Обновляем имя персонажа
        $character->name = $request->name;
        $character->save();

        return response()->json(['success' => true, 'newName' => $character->name]);
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

    public function updateSettings(Request $request)
    {
        // Проверяем, что пользователь авторизован
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Пользователь не авторизован'], 401);
        }

        // Проверяем, что передан корректный идентификатор персонажа
        $character = $user->characters()->find($request->character_id);
        if (!$character) {
            return response()->json(['success' => false, 'error' => 'Персонаж не найден для данного пользователя'], 404);
        }

        // Обновляем данные персонажа
        $character->name = $request->name;
        $character->race = $request->race;
        $character->class = $request->class;
        $character->subclass = $request->subclass;
        $character->save();

        return response()->json([
            'success' => true,
            'newName' => $character->name,
            'newRace' => $character->race,
            'newClass' => $character->class,
            'newSubclass' => $character->subclass
        ]);
    }
}
