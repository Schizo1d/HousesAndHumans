<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Валидация данных формы
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Очищаем сессию, чтобы не оставался прошлый пользователь
        session()->flush();

        // Устанавливаем дефолтный аватар
        $avatar = 'img/default-avatar.png';

        // Создание нового пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,
        ]);

        // Авторизуем пользователя
        Auth::login($user);

        // Перезаписываем сессию
        session([
            'user_name' => $user->name,
            'user_avatar' => asset($user->avatar),
        ]);

        return response()->json(['success' => true, 'redirect' => '/']);
    }


    public function login(Request $request)
    {
        // Очищаем сессию перед авторизацией
        session()->flush();

        // Валидация данных формы
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Попытка авторизации
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Записываем актуальные данные в сессию
            session([
                'user_name' => $user->name,
                'user_avatar' => asset($user->avatar),
            ]);

            return response()->json(['success' => true, 'redirect' => '/']);
        }

        return response()->json(['success' => false, 'message' => 'Неверные данные'], 401);
    }
}
