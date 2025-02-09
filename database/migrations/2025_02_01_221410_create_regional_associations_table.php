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
        Schema::create('regional_associations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('wcif_identifier');
            $table->string('address')->nullable();
            $table->foreignUuid('chairman_contact_id')->nullable();
            $table->foreignUuid('treasurer_contact_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_associations');
    }
};
