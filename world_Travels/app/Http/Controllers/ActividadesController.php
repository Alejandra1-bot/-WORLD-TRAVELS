<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividades;
use Illuminate\Support\Facades\Validator;

class ActividadesController extends Controller
{
    public function index()
    {
        $actividades = Actividades::all();
        return response()->json($actividades);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idCategoria'  => 'required|integer|exists:categorias__actividades,id',
            'idUsuario'    => 'required|integer|exists:usuarios,id',
            'idMunicipio'  => 'required|integer|exists:municipios,id',
            'Nombre_Actividad' => 'required|string|max:255',
            'Descripcion'  => 'required|string',
            'Fecha_Actividad' => 'required|date',
            'Hora_Actividad' => 'required|date_format:H:i',
            'Precio'       => 'required|numeric|min:0',
            'Cupo_Maximo'  => 'required|integer|min:1',
            'Ubicacion'    => 'required|string|max:255',
            'Imagen'       => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $actividad = Actividades::create($validator->validated());
        return response()->json($actividad, 201);
    }

    public function show(string $id)
    {
        $actividad = Actividades::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }

        return response()->json($actividad);
    }

    public function update(Request $request, string $id)
    {
        $actividad = Actividades::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'idCategoria'  => 'integer|exists:categorias__actividades,id',
            'idUsuario'    => 'integer|exists:usuarios,id',
            'idMunicipio'  => 'integer|exists:municipios,id',
            'Nombre_Actividad' => 'string|max:255',
            'Descripcion'  => 'string',
            'Fecha_Actividad' => 'date',
            'Hora_Actividad' => 'date_format:H:i',
            'Precio'       => 'numeric|min:0',
            'Cupo_Maximo'  => 'integer|min:1',
            'Ubicacion'    => 'string|max:255',
            'Imagen'       => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $actividad->update($validator->validated());
        return response()->json($actividad);
    }

    public function destroy(string $id)
    {
        $actividad = Actividades::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada para eliminar'], 404);
        }

        $actividad->delete();
        return response()->json(['message' => 'Actividad eliminada con éxito']);
    }
}
