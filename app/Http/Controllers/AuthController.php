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

        // Генерация случайного 9-значного socialite_id
        do {
            $socialite_id = random_int(100000000, 999999999);
        } while (User::where('socialite_id', $socialite_id)->exists()); // Убеждаемся, что ID уникален

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'socialite_id' => $socialite_id, // Добавляем socialite_id
        ]);

        Auth::login($user);

        return response()->json(['success' => true, 'message' => 'Регистрация успешна!']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => true, 'message' => 'Вход выполнен успешно!']);
        }

        return response()->json(['success' => false, 'message' => 'Неверные данные!'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home'); // Перенаправление на главную
    }
}
