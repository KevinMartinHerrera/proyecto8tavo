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
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_caso')->unique(); // Número único asignado al caso
            $table->date('fecha_apertura'); // Fecha en la que el caso fue abierto
            $table->text('descripcion'); // Descripción detallada del caso
            $table->string('tipo_caso'); // Tipo de caso
            $table->string('estado'); // Estado actual del caso
            $table->date('fecha_cierre')->nullable(); // Fecha en la que el caso fue cerrado
            $table->string('numero_expediente')->unique(); // Número de expediente en el juzgado
            $table->unsignedBigInteger('abogado_id'); // ID del abogado
            $table->unsignedBigInteger('cliente_id'); // ID del cliente
            $table->unsignedBigInteger('carpeta_id')->nullable(); // ID de la carpeta
            $table->timestamps();

            $table->foreign('abogado_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('carpeta_id')->references('id')->on('carpetas')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};
