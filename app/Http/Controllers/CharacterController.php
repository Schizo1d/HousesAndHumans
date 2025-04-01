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
        // Валидация входных данных
        $request->validate([
            'name' => 'required|string|max:255',
            'character_id' => 'required|exists:characters,id'  // Мы теперь передаем ID персонажа
        ]);

        // Получаем текущего авторизованного пользователя
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Пользователь не авторизован'], 401);
        }

        // Получаем персонажа по ID, который был передан в запросе
        $character = $user->characters()->find($request->character_id);

        if (!$character) {
            return response()->json(['success' => false, 'error' => 'Персонаж не найден для данного пользователя'], 404);
        }

        // Обновляем имя персонажа
        $character->name = $request->name;
        $character->save();

        // Теперь нужно сохранить все атрибуты, если они изменены
        // Например, если у персонажа есть атрибуты, их можно обновлять таким образом:
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attribute) {
                // Обновляем атрибуты персонажа, например:
                $character->attributes()->updateOrCreate(
                    ['id' => $attribute['id']], // Найдем атрибут по ID, если он существует
                    ['value' => $attribute['value']] // Обновим или создадим новый атрибут
                );
            }
        }

        return response()->json(['success' => true, 'newName' => $character->name, 'attributes' => $character->attributes]);
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
}
