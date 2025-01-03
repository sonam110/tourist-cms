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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Like India, United States');
            $table->string('country_code',10)->comment('Like IN, US');
            $table->string('dial_code',10)->comment('Like +91, +12');
            $table->string('currency', 50)->comment('Like Indian rupee, United States dollar');
            $table->string('currency_code', 10)->comment('Like INR, USD');
            $table->string('currency_symbol', 50)->comment('Like ₹, $');
            $table->boolean('is_govt_certifcate_valid')->default(false);
            $table->boolean('entry_mode')->default('1')->comment('1:Web,0:Mobile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
