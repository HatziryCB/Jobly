<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

});

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::view('/about', 'about')->name('about');
Route::view('/categories', 'services/categories')->name('categories');


Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migraciones ejecutadas con éxito.';
    } catch (\Throwable $e) {
        return response('Error: ' . $e->getMessage(), 500);
    }
});

Route::get('/debug-db', function () {
    try {
        \DB::connection()->getPdo();
        return '✅ Conexión exitosa a PostgreSQL.';
    } catch (\Exception $e) {
        return '❌ Error de conexión: ' . $e->getMessage();
    }
});

require __DIR__.'/auth.php';

