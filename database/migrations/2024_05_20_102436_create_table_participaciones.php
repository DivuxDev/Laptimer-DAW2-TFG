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
        Schema::create('participaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jugador');
            $table->unsignedBigInteger('id_equipo')->nullable();
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_coche');
            $table->foreign('id_carrera')->references('id')->on('carreras')->onDelete('cascade');
            $table->foreign('id_jugador')->references('id')->on('jugadores')->onDelete('cascade');
            $table->foreign('id_equipo')->references('id')->on('equipos')->onDelete('cascade');
            $table->foreign('id_coche')->references('id')->on('coches')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participaciones');
    }
};
