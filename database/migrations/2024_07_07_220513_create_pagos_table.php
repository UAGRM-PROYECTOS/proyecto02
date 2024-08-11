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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('metodopagos_id');
            $table->unsignedBigInteger('estado_id');
            $table->string('nombre');
            $table->string('transaccion');
            $table->double('monto_pago')->default(00.00);
            $table->timestamp('fecha_pago')->nullable();
            $table->foreign('orden_id')->references('id')->on('ordens')->onDelete('cascade');
            $table->foreign('metodopagos_id')->references('id')->on('metodo_pagos')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
