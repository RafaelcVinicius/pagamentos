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
        Schema::create('payments_status', function (Blueprint $table) {
            $table->id();
            $table->integer("payment_id")->comment('id da venda payments');;;
            $table->string('status');
            $table->string('detail');
            $table->timestamp('date_approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_status');

    }
};
