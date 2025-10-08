<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function(){ return view('home'); })->name('home');


require __DIR__.'/auth.php';
//Ruta de login y register
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

//Rutas de ofertas
Route::middleware(['auth','verified'])->group(function(){
    Route::resource('offers', OfferController::class); // index/create/store/show/edit/update/destroy
});

//Rutas de postulaciones
Route::middleware(['auth','verified'])->group(function(){
    Route::post('offers/{offer}/apply', [ApplicationController::class,'store'])->name('offers.apply');
    Route::post('applications/{application}/accept', [ApplicationController::class,'accept'])->name('applications.accept');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


