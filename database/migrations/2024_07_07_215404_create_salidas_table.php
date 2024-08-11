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
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('metodovaluacion_id');
            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('estado_id');
            $table->timestamp('fecha_salida');
            $table->foreign('orden_id')->references('id')->on('ordens')->onDelete('cascade');
            $table->foreign('metodovaluacion_id')->references('id')->on('metodo_valuacions')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas');
    }
};
