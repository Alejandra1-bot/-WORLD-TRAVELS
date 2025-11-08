<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentarios;
use Illuminate\Support\Facades\Validator;

class ComentariosController extends Controller
{
    public function index()
    {
        $comentarios = Comentarios::all();
        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUsuario'       => 'required|integer|exists:usuarios,id',
            'idActividad'     => 'required|integer|exists:actividades,id',
            'Contenido'       => 'required|string',
            'Calificacion'    => 'required|integer|min:1|max:5',
            'Fecha_Comentario' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comentario = Comentarios::create($validator->validated());
        return response()->json($comentario, 201);
    }

    public function show(string $id)
    {
        $comentario = Comentarios::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        return response()->json($comentario);
    }

    public function update(Request $request, string $id)
    {
        $comentario = Comentarios::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'idUsuario'       => 'integer|exists:usuarios,id',
            'idActividad'     => 'integer|exists:actividades,id',
            'Contenido'       => 'string',
            'Calificacion'    => 'integer|min:1|max:5',
            'Fecha_Comentario' => 'date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comentario->update($validator->validated());
        return response()->json($comentario);
    }

    public function destroy(string $id)
    {
        $comentario = Comentarios::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado para eliminar'], 404);
        }

        $comentario->delete();
        return response()->json(['message' => 'Comentario eliminado con éxito']);
    }
}
