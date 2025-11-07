<?php

use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\User;

Route::middleware(['auth', 'verified'])->group(function () {
    //Mostrar perfil de usuario
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    //Editar perfil
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/employer/{employer}', [EmployerController::class, 'show'])->name('employer.show');
});
