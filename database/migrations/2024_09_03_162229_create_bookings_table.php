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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('package_uuid');

            $table->string('package_name')->nullable();
            $table->string('destination_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('city_of_departure')->nullable();
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->integer('number_of_adults')->default(1);
            $table->integer('number_of_children')->default(0);
            $table->integer('number_of_infants')->default(0);
            $table->string('children_ages')->nullable();
            $table->string('infants_ages')->nullable();
            $table->float('price',10,2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('coupon_code_discount',10,2)->nullable();
            $table->float('payable_amount',10,2)->nullable();
            $table->boolean('status')->default(0)->comment('0:Panding,1:Verified,2:Processed,3:Rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
