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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->enum('destination_type',[1,2])->default(1)->comment('1:domestic, 2:international');
            $table->string('name');
            $table->string('image_path')->nullable();
            $table->boolean('view_on_home')->default(2)->comment('1:true,2:false');
            $table->boolean('status')->default('1')->comment('1:active,2:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
