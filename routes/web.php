<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('home');
})->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/categories', 'categories.index')->name('categories.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
});

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::get('/categories', function(){return view('categories');})->name('categories');

require __DIR__.'/auth.php';

