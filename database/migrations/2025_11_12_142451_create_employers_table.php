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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('full_name')->nullable();
            $table->string('national_card_number')->unique();
            $table->string('national_card_photo')->nullable()->default(null);
            $table->string('household_photo')->nullable()->default(null);
            $table->string('employer_type');
            $table->json('company_documents')->nullable()->default(null);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
