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
            $table->uuid("uuid");
            $table->integer("company_id");
            $table->integer("paymer_id");
            $table->string('payment_id')->nullable()->comment('id da venda payments');;
            $table->decimal('total_amount')->comment('Valor original da venda');
            $table->string('webhook');
            $table->timestamps();
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
