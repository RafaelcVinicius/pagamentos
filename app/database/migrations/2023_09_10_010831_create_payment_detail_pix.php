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
        Schema::create('payment_detail_pix', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payment_id');
            $table->string('e2e_id', 26)->nullable();
            $table->string('qr_code');
            $table->timestamp('expires_on');
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_detail_pix');
    }
};
