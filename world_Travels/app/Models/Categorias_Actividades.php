<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias_Actividades extends Model
{
    protected $table = 'categorias_actividades';
    protected $fillable = [
        'Nombre_Categoria',
        'Descripcion'
    ];

    public function actividades()
    {
        return $this->hasMany(Actividades::class, 'idCategoria');
    }

}
