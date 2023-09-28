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
            $table->bigInteger("gateway_customer_id")->unique()->comment('id do customer mercado pago');
            $table->bigInteger("payer_id");
            $table->bigInteger("gateway_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payers_id')->references('id')->on('payers');
            $table->foreign('gateway_id')->references('id')->on('gateway_mercado_pago');
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
