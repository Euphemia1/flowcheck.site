<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\PurchaseRequestController;
use App\Http\Controllers\Web\VendorController;
use App\Http\Controllers\Web\InvoiceController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', fn () => redirect()->route('login'));

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// Protected app routes
Route::middleware(['auth', 'org.scoped'])->prefix('app')->name('app.')->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardController::class . '@index')->name('dashboard');

    // Purchase Requests
    Route::resource('purchase-requests', PurchaseRequestController::class);
    Route::post('/purchase-requests/{purchaseRequest}/submit', PurchaseRequestController::class . '@submit')
        ->name('purchase-requests.submit');
    Route::post('/purchase-requests/{purchaseRequest}/approve', PurchaseRequestController::class . '@approve')
        ->name('purchase-requests.approve');
    Route::post('/purchase-requests/{purchaseRequest}/reject', PurchaseRequestController::class . '@reject')
        ->name('purchase-requests.reject');

    // Vendors
    Route::resource('vendors', VendorController::class);
    Route::post('/vendors/{vendor}/approve', VendorController::class . '@approve')
        ->name('vendors.approve');

    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/approve', InvoiceController::class . '@approve')
        ->name('invoices.approve');
});
