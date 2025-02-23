<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membership_fee_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('wca_id')->nullable()->index();
            $table->foreignUuid('competition_id')->nullable()->constrained('competitions');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->boolean('waived')->default(false);
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_fee_payments');
    }
};
