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
        Schema::create('dynamic_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            
            $table->string('title');
            $table->text('sub_title');
            $table->string('slug')->unique();
            $table->longtext('content');
            $table->text('banner_image_path')->nullable();
            $table->enum('placed_in',['header_menu','footer_menu','call_by_link']);
            $table->text('seo_keyword')->nullable();
            $table->string('order_number')->nullable();
            $table->boolean('status')->default(1)->comment('1:active,2:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_pages');
    }
};
