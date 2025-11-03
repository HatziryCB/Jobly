<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function(){
    return view('home');
})->name('home');

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::view('/about', 'about')->name('about');
Route::view('/categories', 'services/categories')->name('categories');

Route::get('/debug-manifest', function () {
    $path = public_path('build/manifest.json');
    if (file_exists($path)) {
        return response()->json(['exists' => true, 'path' => $path, 'content' => json_decode(file_get_contents($path), true)]);
    }
    return response()->json(['exists' => false, 'path' => $path]);
});


require __DIR__.'/auth.php';

