<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;

Route::middleware(['auth','verified'])->group(function() {
    Route::resource('offers', OfferController::class)->middleware(['auth', 'verified']);

    Route::post('offers/{offer}/apply', [ApplicationController::class,'store'])->name('offers.apply');
    Route::post('applications/{application}/accept', [ApplicationController::class,'accept'])->name('applications.accept');
});

// routes/applications.php
Route::middleware(['auth', 'role:employee'])->get('/applications', [ApplicationController::class, 'index'])->name('applications.index');

// routes/offers.php
Route::middleware(['auth'])->get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::get('/mis-ofertas', function () {
    $offers = \App\Models\Offer::where('employer_id', auth()->id())->latest()->get();
    return view('offers.mine', compact('offers'));
})->middleware(['auth', 'role:employer'])->name('offers.mine');
