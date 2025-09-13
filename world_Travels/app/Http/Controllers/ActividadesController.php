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
            'idCategoria'  => 'required|integer',
            'idUsuario'    => 'required|integer',
            'idMunicipio'  => 'required|integer',
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha'        => 'required|date',
            'hora'         => 'required',
            'precio'       => 'required|numeric|min:0',
            'cupoMaximo'   => 'required|integer|min:1',
            'ubicacion'    => 'required|string|max:255',
            'imagen'       => 'nullable|string'
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
            'idCategoria'  => 'integer',
            'idUsuario'    => 'integer',
            'idMunicipio'  => 'integer',
            'titulo'       => 'string|max:255',
            'descripcion'  => 'string',
            'fecha'        => 'date',
            'hora'         => '',
            'precio'       => 'numeric|min:0',
            'cupoMaximo'   => 'integer|min:1',
            'ubicacion'    => 'string|max:255',
            'imagen'       => 'nullable|string'
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
