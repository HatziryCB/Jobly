<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class)
            ->only(['index', 'create', 'store']);

        // Futuras rutas:
        // Route::resource('verifications', AdminVerificationController::class);
    });
