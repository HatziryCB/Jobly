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

Route::get('/myOffers', [OfferController::class, 'myOffers'])
    ->name('employer.offers')
    ->middleware(['auth', 'role:employer']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/offers/{offer}', [OfferController::class, 'show'])
        ->name('offers.show');
});
