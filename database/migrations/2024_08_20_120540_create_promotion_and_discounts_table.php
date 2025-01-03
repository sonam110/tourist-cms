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
        Schema::create('promotion_and_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            
            $table->string('title');
            $table->string('coupon_code');
            $table->integer('discount_type')->comment('1:Fixed Amount,2:Percentage Amount');
            $table->double('discount_value',9,2);
            $table->text('description')->nullable();
            $table->string('min_applicable_amount')->nullable();
            $table->string('max_discount')->nullable();
            $table->string('expiry_date')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used')->default(0)->nullable();
            $table->integer('usage_limit_per_user')->nullable();
            $table->text('image_path')->nullable();
            $table->boolean('status')->default(1)->comment('1:active,2:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_and_discounts');
    }
};
