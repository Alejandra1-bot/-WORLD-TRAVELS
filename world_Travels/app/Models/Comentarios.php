<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
     protected $table = 'comentarios';
     protected $fillable = [
          'Contenido',
          'Calificacion',
          'Fecha_Comentario',
          'idUsuario',
          'idActividad'
      ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividades::class, 'idActividad');
    }
}
