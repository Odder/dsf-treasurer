<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WcaAuthController;
use App\Livewire\CompetitionDetails;
use App\Livewire\CompetitionTable;
use App\Livewire\InvoiceDetails;
use App\Livewire\InvoiceTable;
use App\Livewire\LoginScreen;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/invoices');
});

Route::get('/login', LoginScreen::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/invoices', InvoiceTable::class)->name('invoices.index');
    Route::get('/invoices/{invoice}', InvoiceDetails::class)->name('invoices.show');
    Route::patch('/invoices/{invoice}/markAsPaid', [InvoiceController::class, 'markAsPaid'])->name('invoices.markAsPaid');

    Route::get('/competitions', CompetitionTable::class)->name('competitions.index');
    Route::get('/competitions/{competition}', CompetitionDetails::class)->name('competitions.show');
});

Route::get('/auth/wca/redirect', [WcaAuthController::class, 'redirectToProvider']);
Route::get('/auth/wca/callback', [WcaAuthController::class, 'handleProviderCallback']);
