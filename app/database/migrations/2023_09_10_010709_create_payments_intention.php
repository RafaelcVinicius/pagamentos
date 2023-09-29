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
            $table->bigInteger("payer_id");
            $table->string('gateway', 2);
            $table->bigInteger('gateway_id');
            $table->decimal('total_amount')->comment('Valor original da venda');
            $table->string('webhook');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('payer_id')->references('id')->on('payers');
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
