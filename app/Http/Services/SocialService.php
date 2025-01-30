<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocialService
{
    public function saveSocialData($user)
    {
        $email = $user->getEmail();
        $name = $user->getName();
        $avatar = $user->getAvatar();

        $password = Hash::make('123456');

        $data = ['email' => $email, 'name' => $name, 'avatar' => $avatar, 'password' => $password];
        $u = User::where('email', $email)->first();
        if ($u) {
            return $u->fill(['name' => $name, 'avatar' => $avatar]);
        }
        return User::create($data);
    }
}
