<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    /**
     * Nombre de la tabla asociada en la base de datos
     */
    protected $table = 'comentarios';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     * Estos corresponden a las columnas de la tabla.
     */
    protected $fillable = [
        'comentario',        // Texto del comentario
        'calificacion',      // Calificación (ej: estrellas, puntuación)
        'fecha_comentario',  // Fecha en que se hizo el comentario
        'idUsuario',         // Relación con la tabla usuarios
        'idActividad'        // Relación con la tabla actividades
    ];

    /**
     * Relación con Usuarios
     * Un comentario pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario');
    }

    /**
     * Relación con Actividades
     * Un comentario pertenece a una actividad.
     */
    public function actividad()
    {
        return $this->belongsTo(Actividades::class, 'idActividad');
    }
}
