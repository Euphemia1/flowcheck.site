<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('api')->name('api.')->group(function () {
    // PR endpoints
    Route::get('/purchase-requests', 'App\\Http\\Controllers\\Api\\PurchaseRequestController@index');
    Route::post('/purchase-requests', 'App\\Http\\Controllers\\Api\\PurchaseRequestController@store');
    Route::get('/purchase-requests/{purchaseRequest}', 'App\\Http\\Controllers\\Api\\PurchaseRequestController@show');

    // Invoice endpoints
    Route::get('/invoices', 'App\\Http\\Controllers\\Api\\InvoiceController@index');
    Route::post('/invoices', 'App\\Http\\Controllers\\Api\\InvoiceController@store');
    Route::get('/invoices/{invoice}', 'App\\Http\\Controllers\\Api\\InvoiceController@show');

    // Dashboard stats
    Route::get('/dashboard/stats', 'App\\Http\\Controllers\\Api\\DashboardController@stats');
});
