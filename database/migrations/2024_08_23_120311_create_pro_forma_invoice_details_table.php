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
        Schema::create('pro_forma_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_forma_invoice_id');
            $table->foreign('pro_forma_invoice_id')->references('id')->on('pro_forma_invoices')->onDelete('cascade');
            
            $table->text('description');
            $table->string('pax');
            $table->decimal('price',10,2);
            $table->decimal('total',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_forma_invoice_details');
    }
};
