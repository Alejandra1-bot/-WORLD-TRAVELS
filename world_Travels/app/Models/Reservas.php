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
        'fecha_reserva',      // Fecha en que se hace la reserva
        'cantidad_personas',  // Número de personas incluidas en la reserva
        'estado',             // Estado de la reserva (ej: pendiente, confirmada, cancelada)
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
