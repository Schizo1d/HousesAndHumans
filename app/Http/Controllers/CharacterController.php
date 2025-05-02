<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function show($id)
    {
        $character = Character::with('attributes')->find($id);

        if (!$character) {
            return redirect()->route('main')->with('error', 'Персонаж не найден.');
        }

        // Рассчитываем прогресс для отображения
        $xpTable = [
            1 => 0, 2 => 300, 3 => 900, 4 => 2700, 5 => 6500,
            6 => 14000, 7 => 23000, 8 => 34000, 9 => 48000,
            10 => 64000, 11 => 85000, 12 => 100000, 13 => 120000,
            14 => 140000, 15 => 165000, 16 => 195000, 17 => 225000,
            18 => 265000, 19 => 305000, 20 => 355000
        ];

        $currentLevel = $character->level;
        $nextLevel = min($currentLevel + 1, 20);
        $currentLevelXp = $xpTable[$currentLevel] ?? 0;
        $nextLevelXp = $xpTable[$nextLevel] ?? 0;
        $xpInLevel = max(0, $character->experience - $currentLevelXp);
        $xpNeeded = $nextLevelXp - $currentLevelXp;
        $progressPercent = $xpNeeded > 0 ? min(100, ($xpInLevel / $xpNeeded) * 100) : 0;

        return view('character_info', compact('character', 'xpInLevel', 'xpNeeded', 'progressPercent'));
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

    public function updateLevel(Request $request)
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

        // Обновляем уровень персонажа
        $character->level = $request->level;
        $character->save();

        return response()->json(['success' => true]);
    }
    public function updateExperience(Request $request)
    {
        // Проверяем авторизацию
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Не авторизован'], 401);
        }

        // Проверяем данные
        $request->validate([
            'character_id' => 'required|integer',
            'experience' => 'required|integer|min:0',
            'level' => 'required|integer|min:1|max:20' // Изменили на required
        ]);

        // Находим персонажа
        $character = $user->characters()->find($request->character_id);
        if (!$character) {
            return response()->json(['success' => false, 'error' => 'Персонаж не найден'], 404);
        }

        // Обновляем данные
        $character->experience = $request->experience;
        $character->level = $request->level; // Теперь level обязателен

        try {
            $character->save();
            return response()->json([
                'success' => true,
                'newExperience' => $character->experience,
                'newLevel' => $character->level
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Ошибка сохранения: ' . $e->getMessage()
            ], 500);
        }
    }
}
