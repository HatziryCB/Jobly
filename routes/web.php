<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
});

require __DIR__.'/auth.php';

Route::get('/test-role', function () {
    return 'Middleware de Spatie funcionando.';
})->middleware(['auth', 'role:employer']);
