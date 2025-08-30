<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipios;
use Illuminate\Support\Facades\Validator;

class MunicipiosController extends Controller
{
    public function index()
    {
          $municipios = Municipios::all();
        return response()->json($municipios);
    }
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'Nombre'=> 'required|string',
        'idDepartamento'=> 'required|integer',
        
        ]);

        if ($validator-> fails()) {
          return response()->json($validator->errors(), 422);
         }

        $municipios = Municipios::create($validator->validated());
        return response()->json($municipios,201);
    }

    public function show(string $id)   
     {
        $municipios = Municipios::find($id);

        if (!$municipios) { 
            return response()->json(['menssage'=> 'municipio no encontrado'], 404);
        }

        return response()->json($municipios);
    }

    public function update(Request $request, string $id)  
     {
          $municipios = Municipios::find($id);

          if (!$municipios) { 
            return response()->json(['menssage'=> 'municipio no encontrado para editar '], 404);
        }

         $validator = Validator::make($request->all(),[
         'Nombre'=> 'string',
         'idDepartamento'=> 'integer',
         'idActividad'=> 'integer',
        ]);
        

          if ($validator-> fails()) {
          return response()->json($validator->errors(), 422);
        }

        $municipios->update($validator->validated());
        return response()->json($municipios); 
    }

     public function destroy (string $id)
    {
         $municipios = Municipios::find($id);
          if (!$municipios) { 
            return response()->json(['menssage'=> 'municipio no encontrado para eliminar '], 404);
        }
          $municipios->delete();
          return response()->json(['message' => 'municipio eliminado con exito']); 
    } 
     
}
