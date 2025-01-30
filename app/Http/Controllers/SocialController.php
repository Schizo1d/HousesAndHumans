<?php

namespace App\Http\Controllers;

use App\Http\Services\SocialService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function index(){
        return Socialite::driver('vkontakte')->redirect();
    }
    public function callback(){
        $user = Socialite::driver('vkontakte')->user();
        $objSocial = new SocialService();
        if ($objSocial->saveSocialData($user)){
            Auth::login($user);
            return redirect('/');
        }
        return back(400);
    }
}
// https://b589-92-222-100-44.ngrok-free.app
