<?php

use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employer\EmployerDashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    // Dashboard del empleador
    Route::get('/employer/dashboard', [EmployerDashboardController::class, 'index'])
        ->middleware('role:employer')
        ->name('employer.dashboard');

    // Dashboard del empleado
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
        ->middleware('role:employee')
        ->name('employee.dashboard');

    // Dashboard del admin
    Route::get('/admin/dashboard', [AdminVerificationController::class, 'dashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');
});
