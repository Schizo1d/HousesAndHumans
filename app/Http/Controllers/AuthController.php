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

        // Генерация уникального socialite_id
        do {
            $socialite_id = random_int(100000000, 999999999);
        } while (User::where('socialite_id', $socialite_id)->exists());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'socialite_id' => $socialite_id,
        ]);

        Auth::login($user);

        session([
            'user_name' => $user->name,
            'user_avatar' => $user->avatar,
        ]);

        return redirect()->route('home'); // Перенаправление после регистрации
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            session([
                'user_name' => $user->name,
                'user_avatar' => $user->avatar,
            ]);

            return redirect()->route('home'); // Перенаправление после входа
        }

        return back()->withErrors(['email' => 'Неверные данные']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home'); // Перенаправление после выхода
    }
}
