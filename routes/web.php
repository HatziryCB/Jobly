<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function(){
    return view('home');
})->name('home');

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::view('/about', 'about')->name('about');
Route::view('/categories', 'services/categories')->name('categories');

require __DIR__.'/auth.php';

