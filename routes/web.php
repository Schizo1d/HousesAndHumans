<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});
Route::get('/character-list', [CharacterController::class, 'index'])->name('character_list');
Route::get('/main', [MainController::class, 'index'])->name('main');

Auth::routes();

Route::group(['middleware' => 'guest'], function () {
    Route::get('vk/auth', [SocialController::class, 'index'])->name('vk.auth');
});
Route::get('/vk/auth/callback', [SocialController::class, 'callback']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
