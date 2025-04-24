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
    public function updateExperience(Request $request)
    {
        $request->validate([
            'character_id' => 'required|exists:characters,id',
            'experience' => 'required|integer|min:0'
        ]);

        $character = Auth::user()->characters()->findOrFail($request->character_id);

        // Обновляем опыт
        $character->experience = $request->experience;

        // Проверяем уровень
        $newLevel = $this->calculateLevel($character->experience);
        if ($newLevel != $character->level) {
            $character->level = $newLevel;
        }

        $character->save();

        return response()->json([
            'success' => true,
            'level' => $character->level,
            'experience' => $character->experience,
            'next_level_exp' => $this->getNextLevelExp($character->level)
        ]);
    }

    private function calculateLevel($experience)
    {
        $levels = [
            0, 300, 900, 2700, 6500, 14000, 23000, 34000, 48000, 64000,
            85000, 100000, 120000, 140000, 165000, 195000, 225000, 265000, 305000, 355000
        ];

        $level = 1;
        foreach ($levels as $i => $exp) {
            if ($experience >= $exp) {
                $level = $i + 1;
            } else {
                break;
            }
        }

        return min($level, 20); // Максимальный уровень - 20
    }

    private function getNextLevelExp($currentLevel)
    {
        $levels = [
            0, 300, 900, 2700, 6500, 14000, 23000, 34000, 48000, 64000,
            85000, 100000, 120000, 140000, 165000, 195000, 225000, 265000, 305000, 355000
        ];

        return $currentLevel < 20 ? $levels[$currentLevel] : null;
    }
}
