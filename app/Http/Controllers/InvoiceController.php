<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

class InvoiceController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $invoiceTableHtml = Livewire::mount('invoice-table');

        return view('invoices', [
            'invoiceTableHtml' => $invoiceTableHtml,
        ]);
    }

    public function show(Invoice $invoice)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (! Gate::allows('view', $invoice)) {
            abort(403, 'Unauthorized. You are not authorized to view this invoice.');
        }

        return view('invoice', ['invoice' => $invoice]);
    }

    public function markAsPaid(Request $request, Invoice $invoice)
    {
        if (! Gate::allows('markAsPaid', $invoice)) {
            abort(403, 'Unauthorized. You are not authorized to mark this invoice as paid.');
        }

        $invoice->update(['status' => 'paid']);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice marked as paid.');
    }
}
