<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WcaAuthController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/invoices');
});

Route::get('/login', function () {
    return view('splash');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::patch('/invoices/{invoice}/markAsPaid', [InvoiceController::class, 'markAsPaid'])->name('invoices.markAsPaid');

    Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions.index');
    Route::get('/competitions/{competition}', [CompetitionController::class, 'show'])->name('competitions.show');
    Route::post('/competitions/{competition}/refetch-wcif', [CompetitionController::class, 'refetchWcif'])->name('competitions.refetch_wcif');
    Route::post('/competitions/{competition}/generate-invoice', [CompetitionController::class, 'generateInvoice'])->name('competitions.generate_invoice');
});

Route::get('/auth/wca/redirect', [WcaAuthController::class, 'redirectToProvider']);
Route::get('/auth/wca/callback', [WcaAuthController::class, 'handleProviderCallback']);
