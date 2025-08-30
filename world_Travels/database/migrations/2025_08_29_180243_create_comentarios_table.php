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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('Contenido');
            $table->integer('Calificacion')->unsigned()->default(5);
            $table->date('Fecha_Comentario')->default(now());
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
        Schema::dropIfExists('comentarios');
    }
};
