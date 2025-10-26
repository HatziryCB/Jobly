<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;

Route::middleware(['auth','verified'])->group(function() {
    Route::resource('offers', OfferController::class)->middleware(['auth', 'verified']);
});

// routes/offers.php
Route::middleware(['auth'])->get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('offers/create', [OfferController::class, 'create'])->name('offers.create');
    Route::post('offers', [OfferController::class, 'store'])->name('offers.store');
});


