<?php

use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\IdentityVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/verification/create', [IdentityVerificationController::class, 'create'])->name('verification.create');
    Route::post('/verification/store', [IdentityVerificationController::class, 'store'])->name('verification.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/verifications', [AdminVerificationController::class, 'index'])->name('admin.verifications.index');
    Route::get('/verifications/{id}', [AdminVerificationController::class, 'show'])->name('admin.verifications.show');
    Route::post('/verifications/{id}/approve', [AdminVerificationController::class, 'approve'])->name('admin.verifications.approve');
    Route::post('/verifications/{id}/reject', [AdminVerificationController::class, 'reject'])->name('admin.verifications.reject');
    Route::get('/verifications/history', [AdminVerificationController::class, 'history'])->name('admin.verifications.history');
    Route::get('/admin/verifications/user/{user}', [AdminVerificationController::class, 'userHistory'])->name('admin.verifications.user.history');
});
