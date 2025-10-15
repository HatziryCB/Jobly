<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('home');
})->name('home');

//Ruta de login y register
//Route::view('/login', 'auth.login')->name('login');
//Route::view('/register', 'auth.register')->name('register');

//Ruta de autenticación
require __DIR__.'/auth.php';

