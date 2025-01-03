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
        Schema::create('vlogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('categories');
            // $table->longText('content');
            $table->text('video_path')->nullable();
            $table->text('image_path')->nullable();
            $table->integer('order_number')->nullable();
            $table->string('posted_by')->nullable();
            $table->date('post_date')->nullable();
            $table->text('seo_key')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('view_on_home')->default(2)->comment('1:true,2:false');
            $table->boolean('status')->default(1)->comment('1:active,2:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vlogs');
    }
};
