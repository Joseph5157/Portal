<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TopupRequestController;
use App\Http\Controllers\MatrixController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\VendorPayoutController;

Route::get('/', function () {
    return view('welcome');
});

// Client Public Routes
Route::get('/u/{token}', [OrderController::class, 'showUpload'])->name('client.upload');
Route::post('/u/{token}', [OrderController::class, 'store'])->name('client.store');
Route::get('/track/{token_view}', [OrderController::class, 'track'])->name('client.track');
Route::get('/download/{token_view}', [OrderController::class, 'download'])->name('client.download');

Route::middleware(['auth', 'verified'])->group(function () {
    // Vendor/Admin Dashboard Routes
    Route::middleware(['role:vendor'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/orders/{order}/claim', [DashboardController::class, 'claim'])->name('orders.claim');
        Route::post('/orders/{order}/unclaim', [DashboardController::class, 'unclaim'])->name('orders.unclaim');
        Route::post('/orders/{order}/status', [DashboardController::class, 'updateStatus'])->name('orders.status');
        Route::post('/orders/{order}/report', [DashboardController::class, 'uploadReport'])->name('orders.report');
        Route::get('/orders/{order}/files/{file}', [DashboardController::class, 'downloadFile'])->name('orders.files.download');
    });

    // Client Dashboard Routes
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/upload', [ClientDashboardController::class, 'store'])->name('dashboard.upload');
        Route::post('/topup', [TopupRequestController::class, 'store'])->name('topup.store');
    });


});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/accounts/store', [AdminController::class, 'storeAccount'])->name('accounts.store');
    Route::resource('/matrix', \App\Http\Controllers\ClientMatrixController::class)->only(['index', 'update']);
    Route::post('/matrix/{client}/refill', [\App\Http\Controllers\ClientMatrixController::class, 'refill'])->name('matrix.refill');
    Route::post('/topup/{topupRequest}/approve', [TopupRequestController::class, 'approve'])->name('topup.approve');
    Route::post('/topup/{topupRequest}/reject', [TopupRequestController::class, 'reject'])->name('topup.reject');
    Route::get('/billing', [\App\Http\Controllers\BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/{ledger}', [\App\Http\Controllers\BillingController::class, 'show'])->name('billing.show');
    // Finance Section
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/matrix', [MatrixController::class, 'index'])->name('matrix');
        Route::put('/matrix/{client}', [MatrixController::class, 'update'])->name('matrix.update');
        Route::post('/matrix/{client}/refill', [MatrixController::class, 'refill'])->name('matrix.refill');
        Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger');
        Route::get('/payouts', [VendorPayoutController::class, 'index'])->name('payouts.index');
        Route::post('/payouts', [VendorPayoutController::class, 'store'])->name('payouts.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
