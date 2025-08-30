<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
     protected $table = 'actividades';
     protected $fillable = [
        'nombre_actividad',
        'descripcion',
        'fecha',
        'hora',
        'precio',
        'cupo_maximo',
        'ubicacion',
        'imagen',
        'idCategoria',
        'idUsuario',
        'idMunicipio'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorias_Actividades::class, 'idCategoria');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipios::class, 'idMunicipio');
    }

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'idActividad');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'idActividad');
    }
}
