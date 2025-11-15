<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    /**
     * Nombre de la tabla asociada en la base de datos
     */
    protected $table = 'reservas';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     */
    protected $fillable = [
        'Fecha_Reserva',      // Fecha en que se hace la reserva
        'Numero_Personas',    // Número de personas incluidas en la reserva
        'Estado',             // Estado de la reserva (ej: pendiente, confirmada, cancelada)
        'idUsuario',          // Relación con la tabla usuarios
        'idActividad'         // Relación con la tabla actividades
    ];

    /**
     * Relación con Usuarios
     * Una reserva pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario');
    }

    /**
     * Relación con Actividades
     * Una reserva pertenece a una actividad.
     */
    public function actividad()
    {
        return $this->belongsTo(Actividades::class, 'idActividad');
    }
}
