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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Создаём пользователя с дефолтным аватаром
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'img/default-avatar.png', // Указываем путь к дефолтному аватару
        ]);

        Auth::login($user);

        // Сохраняем имя и аватар в сессии
        session([
            'user_name' => $user->name,
            'user_avatar' => $user->avatar,
        ]);

        return response()->json(['success' => true, 'redirect' => '/']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Сохраняем имя и аватар в сессии
            session([
                'user_name' => $user->name,
                'user_avatar' => $user->avatar,
            ]);

            return response()->json(['success' => true, 'redirect' => '/']);
        }

        return response()->json(['success' => false, 'message' => 'Неверные данные'], 401);
    }
}

