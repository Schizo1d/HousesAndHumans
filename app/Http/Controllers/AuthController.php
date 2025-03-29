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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'socialite_id' => random_int(100000000, 999999999),
        ]);

        Auth::login($user);
        session()->regenerate(); // 💥

        session([
            'user_name' => $user->name,
            'user_avatar' => $user->avatar,
        ]);

        return response()->json(['success' => true]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            session()->regenerate(); // 💥 Важно! Перегенерация сессии

            session([
                'user_name' => $user->name,
                'user_avatar' => $user->avatar,
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Неверные данные'], 401);
    }
}
