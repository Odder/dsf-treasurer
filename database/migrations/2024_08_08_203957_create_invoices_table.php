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
            $table->id();
            $table->integer('invoice_number');
            $table->integer('participants');
            $table->integer('non_paying_participants');
            $table->integer('amount')->default(0);
            $table->enum('status', ['paid', 'unpaid', 'draft'])->default('draft');
            $table->foreignId('recipient_id')->nullable();
            $table->foreignId('competition_id')->nullable();
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
