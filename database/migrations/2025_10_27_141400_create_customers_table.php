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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable()->default(null);
            $table->string('nrc')->unique()->nullable()->default(null);
            $table->string('nrc_front')->nullable()->default(null);
            $table->string('nrc_back')->nullable()->default(null);
            $table->string('passport')->unique()->nullable()->default(null);
            $table->string('passport_photo')->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->string('phone')->unique()->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('contact_by')->nullable()->default(null);
            $table->string('social_app')->nullable()->default(null);
            $table->string('social_link_qrcode')->nullable()->default(null);
            $table->string('remark')->nullable()->default(null);
            $table->string('year_of_insurance')->nullable()->default(null);
            $table->decimal('fees', 12, 2)->nullable()->default(null);
            $table->decimal('deposit_amount', 12, 2)->nullable()->default(null);
            $table->decimal('balance', 12, 2)->nullable()->default(null);
            $table->string('pink_card')->nullable()->default(null);
            $table->string('employer')->nullable()->default(null);
            $table->string('employer_type')->nullable()->default(null);
            $table->string('employer_photo')->nullable()->default(null);
            $table->string('employer_household_photo')->nullable()->default(null);
            $table->string('employer_company_data')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
