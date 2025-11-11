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
        if (!Schema::hasTable('actividades')) {
            Schema::create('actividades', function (Blueprint $table) {
                $table->id();
                $table->string('Nombre_Actividad');
                $table->text('Descripcion');
                $table->date('Fecha_Actividad');
                $table->time('Hora_Actividad');
                $table->decimal('Precio', 8, 2);
                $table->unsignedInteger('Cupo_Maximo');
                $table->string('Ubicacion');
                $table->string('Imagen');
                $table->foreignId('idCategoria')->constrained('categorias_actividades')->onDelete('cascade');
                $table->foreignId('idMunicipio')->constrained('municipios')->onDelete('cascade');
                $table->foreignId('idUsuario')->constrained('usuarios')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
