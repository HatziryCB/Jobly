<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat/{user}', [MessageController::class, 'index'])->name('chat.show');
    Route::post('/chat/{user}', [MessageController::class, 'send'])->name('chat.send');
});

