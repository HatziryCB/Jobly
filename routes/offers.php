<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;

Route::middleware(['auth','verified'])->group(function() {
    Route::resource('offers', OfferController::class);

    Route::post('offers/{offer}/apply', [ApplicationController::class,'store'])->name('offers.apply');
    Route::post('applications/{application}/accept', [ApplicationController::class,'accept'])->name('applications.accept');
});
