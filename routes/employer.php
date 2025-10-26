<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employer\EmployerDashboardController;

Route::middleware(['auth', 'verified', 'role:employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
});

Route::get('/employer/offers', [OfferController::class, 'mine'])
    ->name('employer.offers')
    ->middleware(['auth', 'role:employer']);
