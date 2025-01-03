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
        Schema::create('booking_inquiries', function (Blueprint $table) {
            $table->id();
            $table->enum('destination_type',[1,2])->default('1'); // International or Domestic
            $table->string('package_name')->nullable();
            $table->string('destination_name')->nullable();
            $table->date('date_of_departure')->nullable();
            $table->string('city_of_departure')->nullable();
            $table->string('contact_name');
            $table->string('phone_number');
            $table->string('email');
            $table->integer('number_of_adults')->default(1);
            $table->integer('number_of_children')->default(0);
            $table->integer('number_of_infants')->default(0);
            $table->float('budget',10,2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->boolean('status')->default(0)->comment('0:Panding,1:Verified,2:Processed,3:Rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_inquiries');
    }
};
