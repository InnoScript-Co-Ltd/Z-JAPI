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
        Schema::create('visa_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('passport')->unique();
            $table->string('passport_image')->nullable()->default(null);
            $table->string('visa_type');
            $table->string('service_type');
            $table->date('visa_entry_date')->nullable()->default(null);
            $table->date('visa_expiry_date')->nullable()->default(null);
            $table->date('appointment_date')->nullable()->default(null);
            $table->date('new_visa_expired_date')->nullable()->default(null);
            $table->string('status')->default('PROCESSING');
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_services');
    }
};
