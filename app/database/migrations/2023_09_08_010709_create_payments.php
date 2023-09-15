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
            $table->uuid("uuid");
            $table->integer('gateway_payment_id')->unique()->comment('Id externo do gateway de pagamento');
            $table->integer("company_id");
            $table->integer("paymer_id");
            $table->string('payment_type', 20)->comment('Tipo da transação ex: pix cartão...');
            $table->string('gateway', 2);
            $table->integer('gateway_id');
            $table->decimal('origem_amount')->comment('Valor original da venda sem acréscimo');
            $table->decimal('transection_amount')->comment('Valor total da transação com acréscimo');

            $table->timestamps();
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
