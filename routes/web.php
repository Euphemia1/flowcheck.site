<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PurchaseRequestController;
use App\Http\Controllers\Web\VendorController;
use App\Http\Controllers\Web\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'org.scoped'])->prefix('app')->name('app.')->group(function () {
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
