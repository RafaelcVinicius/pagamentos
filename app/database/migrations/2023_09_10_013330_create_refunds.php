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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payment_id')->comment('id da venda payments');
            $table->bigInteger('payment_status_id')->comment('id status refund payments_status');
            $table->decimal('amount');
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('payment_status_id')->references('id')->on('payments_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
