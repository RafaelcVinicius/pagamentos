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
        Schema::create('payers_address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("payer_id");
            $table->string('zip_code', 10);
            $table->string('street_name', 100);
            $table->integer('street_number', 6);
            $table->string('city', 100);
            $table->timestamps();

            $table->foreign('payer_id')->references('id')->on('payers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payers_address');
    }
};
