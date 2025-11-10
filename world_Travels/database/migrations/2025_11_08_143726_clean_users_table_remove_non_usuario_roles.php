<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminar usuarios con roles diferentes a 'usuario'
        DB::table('users')->where('role', '!=', 'usuario')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se puede revertir la eliminación de datos, pero podríamos recrear roles si fuera necesario
        // Para este caso, down() queda vacío ya que no podemos recuperar los datos eliminados
    }
};
