<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:employer')->group(function () {
        Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
        Route::get('/offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
        Route::get('/offer/{offer}/candidates', [OfferController::class, 'candidates'])->name('offers.candidates');
        Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
        Route::put('/offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
        Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
        Route::get('/my-offers', [OfferController::class, 'myOffers'])->name('employer.offers');
    });
    Route::middleware('role:employee|employer|admin')->group(function () {
        Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');
    });
});

