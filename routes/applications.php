<?php
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/offers/{offer}/apply', [ApplicationController::class, 'apply'])->name('offers.apply');
    Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('applications.index');
});
