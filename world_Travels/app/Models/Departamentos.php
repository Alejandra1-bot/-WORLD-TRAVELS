<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    /**
     * Nombre de la tabla asociada en la base de datos
     */
    protected $table = 'departamentos';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     */
    protected $fillable = [
        'Nombre_Departamento' // Nombre del departamento
    ];

    /**
     * Relación con Municipios
     * Un departamento puede tener muchos municipios.
     */
    public function municipios()
    {
        return $this->hasMany(Municipios::class, 'idDepartamento');
    }
}
