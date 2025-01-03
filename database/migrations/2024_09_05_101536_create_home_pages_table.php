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
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->text('short_description');
            $table->string('banner_image_path')->nullable();
            $table->text('image_path')->nullable();
            $table->string('video_path')->nullable();
            $table->string('duration')->nullable();
            $table->longText('promo')->nullable()->comment('input will be array .. saved will be in json');
            $table->longText('destination')->nullable()->comment('input will be array .. saved will be in json');
            $table->string('newsletter_video_path')->nullable();
            $table->string('newsletter_title')->nullable();
            $table->text('newsletter_description')->nullable();
            $table->boolean('special')->default(1)->comment('1:true,2:normal');
            $table->boolean('featured')->default(1)->comment('1:true,2:false');
            $table->boolean('blog')->default(1)->comment('1:true,2:false');
            $table->boolean('testimonial')->default(1)->comment('1:true,2:false');
            $table->boolean('activity')->default(1)->comment('1:true,2:false');
            $table->boolean('happy_customers')->default(1)->comment('1:true,2:false');
            $table->boolean('newsletter')->default(1)->comment('1:true,2:false');
            $table->text('happy_customers_images')->nullable()->comment('will be multiple');
            $table->string('happy_customers_title')->nullable();
            $table->text('happy_customers_sub_title')->nullable();
            $table->text('extra_description')->nullable();
            $table->string('background_video_url')->nullable();
            $table->boolean('background_video_on')->default(1)->comment('1:true,2:normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
