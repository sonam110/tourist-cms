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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->enum('userType', ['admin','user'])->default('user');
            $table->integer('role_id')->comment('1 for admin,2 for user')->nullable();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verified_token')->nullable();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('profile_image')->default('avatar.jpg')->nullable();
            $table->string('banner_image')->default('img/images/account-cover-img.jpg')->nullable();
            $table->text('address')->nullable();
            $table->string('locktimeout')->default('10')->comment('System auto logout if no activity found.');
            $table->enum('status', ['1','2'])->default('1')->comment('1:Active, 2:Inactive');
            $table->string('provider_name')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
