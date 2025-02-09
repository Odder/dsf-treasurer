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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('invoice_number')->nullable();
            $table->integer('participants');
            $table->integer('non_paying_participants');
            $table->integer('amount')->default(0);
            $table->enum('status', ['paid', 'unpaid', 'draft'])->default('draft');
            $table->foreignUuid('recipient_id')->nullable();
            $table->foreignUuid('competition_id')->nullable();
            $table->foreignUuid('association_id')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
