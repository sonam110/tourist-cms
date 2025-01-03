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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            $table->unsignedBigInteger('destination_id')->nullable();
            $table->foreign('destination_id')->references('id')->on('destinations')->comment('To identify destinations')->onDelete('cascade');

            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->comment('To identify destinations')->onDelete('cascade');

            $table->string('activities')->nullable()->comment('input will be array of activity_id .. saved will be in json');

            $table->enum('data_for',['package','activity'])->default('package');
            $table->string('package_name');
            $table->string('slug');
            $table->string('package_type')->nullable();
            $table->longText('description');
            $table->string('duration');
            $table->longText('inclusions')->comment('input will be array .. saved will be in json');
            $table->longText('exclusions')->nullable()->comment('input will be array .. saved will be in json');
            $table->longText('itinerary')->nullable()->comment('input will be array .. saved will be in json');
            // $table->longText('activities')->nullable()->comment('input will be array .. saved will be in json');
            $table->text('available_dates')->comment('input will be array in form of start date and end date .. saved will be in json');
            $table->float('price_in_currency_1',14,2);
            $table->float('price_in_currency_2',14,2);
            $table->float('price_in_currency_3',14,2);
            $table->float('price_in_currency_4',14,2);
            $table->float('price_in_currency_5',14,2);
            $table->text('terms_and_conditions')->nullable();
            $table->boolean('special')->default(2)->comment('1:true,2:normal');
            $table->boolean('featured')->default(2)->comment('1:true,2:false');
            $table->boolean('view_on_home')->default(2)->comment('1:true,2:false');
            $table->boolean('trending')->default(2)->comment('1:true,2:false');
            $table->string('rating')->nullable()->default(0);
            $table->boolean('status')->default(1)->comment('1:active,2:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
