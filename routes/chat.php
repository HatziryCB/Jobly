<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat/{user}', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat/{user}', [MessageController::class, 'send'])->name('chat.send');
    Route::delete('/applications/{application}/cancel', [ApplicationController::class, 'cancel'])->middleware('role:employee')->name('applications.cancel');

});
