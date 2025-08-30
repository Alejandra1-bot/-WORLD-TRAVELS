<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $table = 'departamentos';
    protected $fillable = [
        'Nombre_Departamento'
    ];

    public function municipios()
    {
        return $this->hasMany(Municipios::class, 'idDepartamento');
    }
}
