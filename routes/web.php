<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WcaAuthController;
use App\Livewire\CompetitionDetails;
use App\Livewire\CompetitionTable;
use App\Livewire\ContactInfoDetails;
use App\Livewire\ContactInfoTable;
use App\Livewire\InvoiceDetails;
use App\Livewire\InvoiceTable;
use App\Livewire\LoginScreen;
use App\Livewire\MyReceipts;
use App\Livewire\RegionalAssociationDetails;
use App\Livewire\RegionalAssociationEditBoard;
use App\Livewire\RegionalAssociationTable;
use App\Livewire\UploadReceipt;
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

    Route::get('/regional-associations', RegionalAssociationTable::class)->name('regional-associations.index');
    Route::get('/regional-associations/{regionalAssociation}', RegionalAssociationDetails::class)->name('regional-associations.show');
    Route::get('/regional-associations/{regionalAssociation}/edit-board', RegionalAssociationEditBoard::class)->name('regional-associations.edit-board');

    Route::get('/receipts/upload', UploadReceipt::class)->name('receipts.upload');
    Route::get('/me/receipts', MyReceipts::class)->name('receipts.mine');

    Route::middleware(['can:managePeople'])->group(function () {

        Route::get('/people', ContactInfoTable::class)->name('people.index');
        Route::get('/people/{contactInfo}', ContactInfoDetails::class)->name('people.show');
    });

    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');
});

Route::get('/auth/wca/redirect', [WcaAuthController::class, 'redirectToProvider']);
Route::get('/auth/wca/callback', [WcaAuthController::class, 'handleProviderCallback']);
