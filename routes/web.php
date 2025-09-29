<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MMS\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MMS\PackageController;
use App\Http\Controllers\MMS\TransactionReportController;
use App\Http\Controllers\UserController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login/check-login', [LoginController::class, 'login'])->name('login.check-login');
});

Route::middleware(['auth', 'prevent-back-history', 'convert-utf-8'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/get-admin-dashboard-chart-data', [DashboardController::class, 'getAdminDashboardChartData'])->name('dashboard.get-admin-dashboard-chart-data');
    Route::get('/get-user-dashboard-chart-data', [DashboardController::class, 'getUserDashboardChartData'])->name('dashboard.get-user-dashboard-chart-data');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/get-user-profile/{id}', [UserController::class, 'getUserProfile'])->name('users.get-user-profile');
        Route::post('/data', [UserController::class, 'data'])->name('users.data');
        Route::post('/register', [UserController::class, 'register'])->name('users.register');
        Route::post('/membership-history', [UserController::class, 'membershipHistory'])->name('users.membership-history');
        Route::post('/renew-membership', [UserController::class, 'renewMembership'])->name('users.renew-membership');
        Route::post('/deactivate-membership', [UserController::class, 'deactivateMembership'])->name('users.deactivate-membership');
        Route::post('/check-in', [UserController::class, 'checkIn'])->name('users.check-in');
        Route::post('update', [UserController::class, 'update'])->name('users.update');
    });

    Route::prefix('packages')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('packages');
        Route::get('/get-all-data', [PackageController::class, 'getAllData'])->name('packages.get-all-data');
        Route::get('/get-package-by-id/{id}', [PackageController::class, 'getPackageById'])->name('packages.get-package-by-id');
        Route::post('/', [PackageController::class, 'store'])->name('packages.store');
        Route::post('/data', [PackageController::class, 'data'])->name('packages.data');
        Route::put('/{id}/update', [PackageController::class, 'update'])->name('packages.update');
    });

    Route::prefix('transaction-report')->group(function () {
        Route::get('/', [TransactionReportController::class, 'index'])->name('transaction-report');
        Route::post('/data', [TransactionReportController::class, 'data'])->name('transaction-report.data');
        Route::post('/get-document-numbers', [TransactionReportController::class, 'getDocumentNumbers'])->name('transaction-report.get-document-numbers');
        Route::post('/get-package-types', [TransactionReportController::class, 'getPackageTypes'])->name('transaction-report.get-package-types');
        Route::post('/get-package-names', [TransactionReportController::class, 'getPackageNames'])->name('transaction-report.get-package-names');
        Route::post('/get-total-payment', [TransactionReportController::class, 'getTotalPayment'])->name('transaction-report.get-total-payment');

    });

    Route::post('/logout', LogoutController::class)->name('logout');
});