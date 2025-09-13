<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias_Actividades;
use Illuminate\Support\Facades\Validator;

class CategoriasActividadesController extends Controller
{
    public function index()
    {
        $categorias = Categorias_Actividades::all();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_categoria' => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
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
            'nombre_categoria' => 'string|max:255',
            'descripcion'      => 'nullable|string',
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
