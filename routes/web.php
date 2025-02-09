<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WcaAuthController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::patch('/invoices/{invoice}/markAsPaid', [InvoiceController::class, 'markAsPaid'])->name('invoices.markAsPaid');

Route::get('/api/invoices', function () {
    return Invoice::all();
});

Route::get('/auth/wca/redirect', [WcaAuthController::class, 'redirectToProvider']);
Route::get('/auth/wca/callback', [WcaAuthController::class, 'handleProviderCallback']);
