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
            $table->string("gateway_customer_id", 25)->unique()->comment('id do customer mercado pago');
            $table->bigInteger("payer_id");
            $table->timestamps();

            $table->foreign('payer_id')->references('id')->on('payers');
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
