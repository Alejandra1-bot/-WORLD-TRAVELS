<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias_Actividades extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'categorias__actividades';

    // Campos que se pueden asignar de manera masiva (mass assignment)
    protected $fillable = [
        'Nombre_Categoria', // Nombre de la categoría
        'Descripcion'       // Descripción de la categoría
    ];
}
