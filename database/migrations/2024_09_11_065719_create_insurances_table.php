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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->date('travel_start_date');
            $table->date('travel_end_date');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->integer('number_of_adults')->default(1);
            $table->integer('number_of_children')->default(0);
            $table->string('children_ages')->nullable();
            $table->integer('number_of_infants')->default(0);
            $table->string('infants_ages')->nullable();
            $table->boolean('status')->default(0)->comment('0:Panding,1:Verified,2:Processed,3:Rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
