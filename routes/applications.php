<?php
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/employee/{offer}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('employee.applications');
    Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
});

Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('/offers/{offer}/candidates', [CandidateController::class, 'index'])->name('offers.candidates');
    Route::get('/offers/{offer}/candidates/{employee}', [CandidateController::class, 'show'])->name('offers.candidates.show');
    Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');

});
