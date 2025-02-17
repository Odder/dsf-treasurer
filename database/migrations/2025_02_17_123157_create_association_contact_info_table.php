<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RegionalAssociation;
use App\Models\AssociationMembership;
use App\Enums\AssociationRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('association_contact_info', function (Blueprint $table) {
            $table->foreignUuid('regional_association_id')->constrained('regional_associations')->cascadeOnDelete();
            $table->foreignUuid('contact_info_id')->constrained('contact_infos')->cascadeOnDelete();
            $table->string('role');
            $table->timestamps();
        });

        Schema::table('regional_associations', function (Blueprint $table) {
            $table->dropColumn(['chairman_contact_id', 'treasurer_contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regional_associations', function (Blueprint $table) {
            $table->foreignUuid('chairman_contact_id')->nullable();
            $table->foreignUuid('treasurer_contact_id')->nullable();
        });

        Schema::dropIfExists('association_contact_info');
    }
};
