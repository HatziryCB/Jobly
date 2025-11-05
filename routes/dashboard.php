<?php

use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employer\EmployerDashboardController;
use Illuminate\Support\Facades\Route;

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::middleware('role:employer')->get('/employer/dashboard', [EmployerDashboardController::class, 'index'])->name('employer.dashboard');
        Route::middleware('role:employee')->get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
        Route::middleware('role:admin')->get('/admin/dashboard', [AdminVerificationController::class, 'dashboard'])->name('admin.dashboard');
    });
