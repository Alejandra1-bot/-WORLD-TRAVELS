<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias_Actividades;
use Illuminate\Support\Facades\Validator;

class Categorias_ActividadesController extends Controller
{
    public function index()
    {
        $categorias = Categorias_Actividades::all();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre_Categoria' => 'required|string|max:255|unique:categorias__actividades',
            'Descripcion'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categoria = Categorias_Actividades::create($validator->validated());
        return response()->json($categoria, 201);
    }

    public function show(string $id)
    {
        $categoria = Categorias_Actividades::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    public function update(Request $request, string $id)
    {
        $categoria = Categorias_Actividades::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'Nombre_Categoria' => 'string|max:255|unique:categorias__actividades,nombre_categoria,'.$id,
            'Descripcion'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categoria->update($validator->validated());
        return response()->json($categoria);
    }

    public function destroy(string $id)
    {
        $categoria = Categorias_Actividades::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada para eliminar'], 404);
        }

        $categoria->delete();
        return response()->json(['message' => 'Categoría eliminada con éxito']);
    }
}
