<?php

use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Invoice::all()->each(function (Invoice $invoice) {
            $invoice->amount = $invoice->lines()->sum('total_price');
            $invoice->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Invoice::all()->each(function (Invoice $invoice) {
            $invoice->amount = 0;
            $invoice->save();
        });
    }
};
