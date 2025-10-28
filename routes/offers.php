<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;

Route::middleware(['auth', 'verified'])->group(function () {
    //Ver detalles de oferta
    Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');

    //Empleador
    Route::middleware('role:employer')->group(function () {
        Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
        Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
        Route::get('/offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
        Route::put('/offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
        Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
        Route::get('/my-offers', [OfferController::class, 'myOffers'])->name('employer.offers');
        Route::get('/offer/{offer}/candidates', [OfferController::class, 'candidates'])->name('offers.candidates');
    });
});
