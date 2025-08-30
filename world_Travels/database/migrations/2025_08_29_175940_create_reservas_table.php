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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha_Reserva');
            $table->integer('Numero_Personas');
            $table->enum('Estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');
            $table->foreignId('idUsuario')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('idActividad')->constrained('actividades')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
