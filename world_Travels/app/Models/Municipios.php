<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
     protected $table = 'municipios';
     protected $fillable = [
       'Nombre_Municipio',
       'idDepartamento',
 
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
