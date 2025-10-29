<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\User;

Route::middleware('auth')->group(function () {
    //Mostrar perfil de usuario
    Route::get('/user/{user}', [ProfileController::class, 'show'])->name('profile.show');
    //Editar perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
