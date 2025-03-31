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

        // Проверка на наличие аватара, если не передан, устанавливаем дефолтный
        $avatar = $request->has('avatar') ? $request->avatar : 'img/default-avatar.png';

        // Создание нового пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,  // Устанавливаем путь к аватару
        ]);

        // Авторизация пользователя
        Auth::login($user);

        // Сохранение данных пользователя в сессии
        session([
            'user_name' => $user->name,
            'user_avatar' => asset($user->avatar),  // Делаем путь абсолютным
        ]);

        return response()->json(['success' => true, 'redirect' => '/']);
    }


    public function login(Request $request)
    {
        // Валидация данных формы
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Попытка авторизации
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Сохранение данных пользователя в сессии
            session([
                'user_name' => $user->name,
                'user_avatar' => asset($user->avatar),  // Делаем путь абсолютным
            ]);

            return response()->json(['success' => true, 'redirect' => '/']);
        }

        return response()->json(['success' => false, 'message' => 'Неверные данные'], 401);
    }
}
