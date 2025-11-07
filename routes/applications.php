<?php
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/employee/{offer}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('employee.applications');
});

Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('/offer/{offer}/candidates', [CandidateController::class, 'index'])->name('applications.candidates');
    Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
    Route::get('/offer/{offer}/candidates/{employee}', [CandidateController::class, 'show'])->name('applications.candidate.show');
});
