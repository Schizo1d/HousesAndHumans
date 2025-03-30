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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => asset('img/default-avatar.png'), // Аватар по умолчанию
            ]);

            Auth::login($user);

            // Очищаем и обновляем сессию
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Записываем данные пользователя в сессию
            session([
                'user_name' => $user->name,
                'user_avatar' => $user->avatar,
            ]);

            return response()->json(['success' => true, 'redirect' => '/']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ошибка регистрации: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Очищаем всю сессию перед записью новых данных
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Обновляем данные сессии с новым пользователем
            session([
                'user_name' => $user->name,
                'user_avatar' => $user->avatar ?? asset('img/default-avatar.png'), // Указываем аватар по умолчанию
            ]);

            return response()->json(['success' => true, 'redirect' => '/']);
        }

        return response()->json(['success' => false, 'message' => 'Неверные данные'], 401);
    }
}
