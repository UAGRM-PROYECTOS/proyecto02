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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('cod_barra')->default('PROXXX');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('unidad');
            $table->string('imagen')->nullable();
            $table->double('precio')->default(00.00);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('stock_min')->default(5);
            $table->unsignedBigInteger('categoria_id');
            $table->timestamps();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
