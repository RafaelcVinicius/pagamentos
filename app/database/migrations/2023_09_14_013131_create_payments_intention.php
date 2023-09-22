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
        Schema::create('payments_intention', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->bigInteger("company_id");
            $table->bigInteger("paymer_id");
            $table->bigInteger('payment_id')->nullable()->comment('id da venda payments');
            $table->decimal('total_amount')->comment('Valor original da venda');
            $table->string('webhook');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('paymer_id')->references('id')->on('payers');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_intention');
    }
};
