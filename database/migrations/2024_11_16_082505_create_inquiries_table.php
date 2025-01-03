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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable(); // Email of the user
            $table->string('mobile')->nullable(); // Mobile number
            $table->date('travel_date')->nullable(); // Travel date
            $table->unsignedInteger('traveller_count')->nullable(); // Number of travelers
            $table->string('package_id')->nullable(); // Package ID
            $table->text('message')->nullable(); // Optional message
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
