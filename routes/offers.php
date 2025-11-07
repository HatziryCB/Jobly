<?php


use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:employer')->group(function () {
        Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
        Route::get('/offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
        Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
        Route::put('/offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
        Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
        Route::get('/my-offers', [OfferController::class, 'myOffers'])->name('employer.offers');
    });
    Route::middleware('role:employee|employer|admin')->group(function () {
        Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');
    });
    // === Gestión de contratación ===
    Route::post('/offers/{offer}/hire/{candidate}', [OfferController::class, 'hireCandidate'])
        ->middleware('role:employer')
        ->name('offers.hire');
    Route::post('/offers/{offer}/confirm', [OfferController::class, 'confirmParticipation'])
        ->middleware('role:employee')
        ->name('offers.confirm');
    Route::post('/offers/{offer}/complete', [OfferController::class, 'markCompleted'])
        ->middleware('auth')
        ->name('offers.complete');
    Route::post('/offers/{offer}/cancel', [OfferController::class, 'cancelOffer'])
        ->middleware('auth')
        ->name('offers.cancel');
});



