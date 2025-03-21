<?php

use App\Http\Controllers\CharacterAttributeController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('main');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Auth::routes();

Route::post('/character/{character}/attributes', [CharacterAttributeController::class, 'store'])
    ->name('character_attributes.store');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::get('/character_list', [CharacterController::class, 'index'])->name('character_list');

Route::get('/main', [MainController::class, 'index'])->name('main');

Route::get('/character/{id}', [CharacterController::class, 'show'])->name('character_info');

Route::group(['middleware' => 'guest'], function () {
    Route::get('vk/auth', [SocialController::class, 'index'])->name('vk.auth');
});

Route::get('/vk/auth/callback', [SocialController::class, 'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Роуты для персонажей с авторизацией
Route::middleware(['auth'])->group(function () {
    Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');
    Route::delete('/characters/{character}', [CharacterController::class, 'destroy'])->name('characters.destroy');
});

