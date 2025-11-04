<?php

use App\Http\Controllers\IdentityVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/verification', [IdentityVerificationController::class, 'create'])->name('verification.create');
    Route::post('/verification', [IdentityVerificationController::class, 'store'])->name('verification.store');
});
