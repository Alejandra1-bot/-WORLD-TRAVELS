<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
     protected $table = 'reservas';
     protected $fillable = [
 
          'Fecha_Reserva',
          'Numero_Personas',
          'Estado',
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
