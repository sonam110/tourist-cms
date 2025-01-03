<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appsettings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name');
            $table->longText('description')->nullable();
            $table->string('app_logo')->default('assets/images/logo.png');
            $table->string('email')->nullable();
            $table->string('mobilenum')->nullable();
            $table->string('app_key')->nullable();
            $table->string('logo_thumb_path')->default('assets/images/logo.png')->nullable();
            $table->string('fav_icon')->default('favicon.ico')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('insta_url')->nullable();
            $table->string('linkedIn_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->string('copyright_text')->nullable();
            $table->text('address')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('google_analytics')->nullable();
            $table->string('default_language')->nullable();
            $table->string('default_currency')->nullable();
            $table->longText('footer_description')->nullable();
            $table->text('pro_forma_invoice_remarks')->nullable();
            $table->string('footer_logo')->default('assets/images/logo.png');
            $table->string('payment_image')->nullable();
            $table->text('contact_description')->nullable();
            $table->string('contact_title')->nullable();
            $table->boolean('ads_enabled')->default(1)->nullable()->comment('1:enabled,2:disabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appsettings');
    }
}
