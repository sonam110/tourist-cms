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
        Schema::create('travel_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique();
            // $table->string('categories');
            $table->longText('content');
            $table->text('image_path')->nullable();
            $table->text('video_link')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->boolean('status')->default(1)->comment('1:active,2:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_courses');
    }
};
