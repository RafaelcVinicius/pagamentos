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
        Schema::create('gateway_mercado_pago', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid");
            $table->integer("gateway_type");
            $table->integer("company_id");
            $table->string('public_key');
            $table->string('access_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_mercado_pago');
    }
};
