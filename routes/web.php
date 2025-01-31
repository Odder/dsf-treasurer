<?php

use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/invoices/{invoice}', function (Invoice $invoice) {
    return view('invoice', ['invoice' => $invoice]);
});

Route::get('/api/invoices', function () {
    return Invoice::all();
});
