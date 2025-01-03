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
        Schema::create('pro_forma_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->text('address');
            $table->string('invoice_number')->unique();
            $table->date('date');
            $table->integer('billing_address');
            $table->integer('bank_detail');
            $table->decimal('total', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->decimal('advance', 10, 2)->default(0)->nullable();
            $table->decimal('due', 10, 2)->default(0)->nullable();
            $table->text('remarks')->nullable();
            $table->integer('remarks_enabled')->nullable();
            $table->integer('gst_enabled')->default(0)->nullable();
            $table->integer('show_system_gen')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_forma_invoices');
    }
};
