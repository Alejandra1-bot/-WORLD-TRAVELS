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
            'idUsuario'       => 'required|integer',
            'idActividad'     => 'required|integer',
            'contenido'       => 'required|string',
            'fechaComentario' => 'required|date'
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
            'idUsuario'       => 'integer',
            'idActividad'     => 'integer',
            'contenido'       => 'string',
            'fechaComentario' => 'date'
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
