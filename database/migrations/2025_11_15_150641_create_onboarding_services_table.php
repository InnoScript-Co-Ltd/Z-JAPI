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
        Schema::create('onboarding_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('customer_name');
            $table->foreignId('category_id');
            $table->string('category');
            $table->foreignId('category_service_id');
            $table->string('service');
            $table->decimal('fees', 12, 2);
            $table->decimal('deposit', 12, 2);
            $table->decimal('balance', 12, 2);
            $table->string('employer_type');
            $table->foreignId('employer_id');
            $table->string('employer_name');
            $table->string('status');
            $table->string('remark')->default(null);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_services');
    }
};
