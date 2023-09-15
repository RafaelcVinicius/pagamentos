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
        Schema::create('customers_mercado_pago', function (Blueprint $table) {
            $table->id();
            $table->integer("gateway_customer_id")->unique()->comment('id da venda payments');;;
            $table->integer("paymer_id");
            $table->integer("gateway_id");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_mercado_pago');
    }
};
