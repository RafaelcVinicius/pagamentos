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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->bigInteger('gateway_payment_id')->unique()->comment('Id externo do gateway de pagamento');
            $table->bigInteger("company_id");
            $table->bigInteger("paymer_id");
            $table->string('payment_type', 20)->comment('Tipo da transação ex: pix cartão...');
            $table->string('gateway', 2);
            $table->bigInteger('gateway_id');
            $table->decimal('origem_amount')->comment('Valor original da venda sem acréscimo');
            $table->decimal('transection_amount')->comment('Valor total da transação com acréscimo');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('paymer_id')->references('id')->on('payers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
