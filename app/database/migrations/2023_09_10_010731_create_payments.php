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
            $table->string('email', 100);
            $table->bigInteger('payment_intention_id');
            $table->bigInteger('gateway_payment_id')->unique()->comment('Id externo do gateway de pagamento');
            $table->string('payment_type', 20)->comment('Tipo da transação ex: pix cartão...');
            $table->integer('installments', 2)->comment('parcelas');
            $table->decimal('transection_amount')->comment('Valor total da transação com acréscimo');
            $table->timestamps();

            $table->foreign('payment_intention_id')->references('id')->on('payments_intention');
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
