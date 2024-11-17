<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

//Start strony
Route::get('/', function () {
    return redirect('/login');
});


// Widok czatu i lista użytkowników
Route::get('/users', [UserController::class, 'index'])->name('users.index');
// Pobieranie listy użytkowników
Route::get('/users/getUsers', [UserController::class, 'getUsers'])->name('users.getUsers');
// Wyszukiwanie użytkowników
Route::post('/users/search', [UserController::class, 'search'])->name('users.search');
Route::get('/users/getUsers', [UserController::class, 'getUsers'])->middleware('auth');
// Trasa usuwania użytkownika
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::post('/save', [ChatController::class, 'saveMessage']);
Route::get('/process', [ChatController::class, 'getMessages']);
Route::post('/savePrivate', [ChatController::class, 'savePrivateMessage']);
Route::get('/getPrivateMessages/{userId}', [ChatController::class, 'getPrivateMessages']);

// Widok użytkowników
Route::middleware('auth')->get('/users', [UserController::class, 'index'])->name('users.index');
// Trasa do czatu
Route::middleware('auth')->get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
