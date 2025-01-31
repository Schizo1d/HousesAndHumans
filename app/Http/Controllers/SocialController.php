<?php

namespace App\Http\Controllers;

use App\Http\Services\SocialService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function index(){
        return Socialite::driver('vkontakte')->redirect();
    }
    public function callback() {
        // Получаем информацию о пользователе от Socialite
        $socialiteUser = Socialite::driver('vkontakte')->user();

        // Проверяем, существует ли пользователь в базе данных по ID из соцсети
        $existingUser = User::where('socialite_id', $socialiteUser->getId())->first();

        if (!$existingUser) {
            // Если пользователь не найден, создаем нового
            $existingUser = User::create([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'socialite_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
                'id'=>$socialiteUser->getId(),
                'password' => '',
                // Добавьте другие необходимые поля
            ]);
        }

        // Выполняем вход пользователя в систему
        Auth::login($existingUser);

        session([
            'user_name' => $existingUser->name,
            'user_avatar' => $existingUser->avatar,
        ]);

        // Перенаправляем на главную страницу после успешного входа
        return redirect('/');
    }
}

