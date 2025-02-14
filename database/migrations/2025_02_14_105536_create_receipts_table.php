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
        Schema::create('receipts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('association_id')->nullable()->constrained('regional_associations')->nullOnDelete();
            $table->foreignUuid('competition_id')->nullable()->constrained('competitions')->nullOnDelete();

            $table->string('image_path');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('description')->nullable();
            $table->string('bank_account_reg')->nullable();
            $table->string('bank_account_number')->nullable();

            $table->enum('status', ['reported', 'accepted', 'rejected', 'settled'])->default('reported');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
