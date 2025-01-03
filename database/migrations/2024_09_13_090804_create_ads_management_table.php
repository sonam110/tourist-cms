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
        Schema::create('ads_management', function (Blueprint $table) {
            $table->id();
            $table->text('image_path')->nullable();
            $table->text('url_link')->nullable();
            $table->text('page_name')->nullable();
            $table->integer('status')->default(1)->comment('1:true,2:false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_management');
    }
};
