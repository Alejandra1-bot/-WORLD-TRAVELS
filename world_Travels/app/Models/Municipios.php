<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    /**
     * Nombre de la tabla asociada en la base de datos
     */
    protected $table = 'municipios';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     */
    protected $fillable = [ 
        'Nombre_Municipio', // Nombre del municipio
        'idDepartamento'    // Relación con la tabla departamentos
    ];

    /**
     * Relación con Departamentos
     * Un municipio pertenece a un departamento.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamentos::class, 'idDepartamento');
    }

    /**
     * Relación con Actividades
     * Un municipio puede tener muchas actividades.
     */
    public function actividades()
    {
        return $this->hasMany(Actividades::class, 'idMunicipio');
    }
}
