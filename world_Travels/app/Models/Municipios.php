<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
     protected $table = 'municipios';
     protected $fillable = [ 
     'nombre_municipio',
     'idDepartamento',
     'idActividad'
     ];

    public function departamento()
    {
        return $this->belongsTo(Departamentos::class, 'idDepartamento');
    }

    public function actividades()
    {
        return $this->hasMany(Actividades::class, 'idMunicipio');
    }
}
