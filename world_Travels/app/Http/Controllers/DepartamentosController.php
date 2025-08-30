<?php

namespace App\Http\Controllers;
use App\Models\Departamentos;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    public function index()
    {
        $departamentos = Departamentos::all();
        return response()->json($departamentos);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'Nombre_Departamento'=> 'required|string'
        ]);

         if ($validator-> fails()) {
          return response()->json($validator->errors(), 422);
         }

        $departamentos = Departamentos::create($validator->validated());
        return response()->json($departamentos,201);  
    }
     public function show(string $id)   
    {
            $departamentos = Departamentos::find($id);
    
            if (!$departamentos) { 
                return response()->json(['menssage'=> 'Departamento no encontrado'], 404);
            }
    
            return response()->json($departamentos);
    }

     public function update(Request $request, string $id)  
    {
          $departamentos = Departamentos::find($id);

          if (!$departamentos) { 
            return response()->json(['menssage'=> 'Departamento no encontrado para editar '], 404);
         }

         $validator = Validator::make($request->all(),[
         'Nombre_Departamento'=> 'string',
          
        ]);
        

          if ($validator-> fails()) {
         return response()->json($validator->errors(), 422);
         }

        $departamentos->update($validator->validated());
        return response()->json($departamentos); 
     }

      public function destroy (string $id)
     {
         $departamentos = Departamentos::find($id);
          if (!$departamentos) { 
            return response()->json(['menssage'=> 'Departamento no encontrado para eliminar '], 404);
        }
          $departamentos->delete();
          return response()->json(['message' => 'Departamento eliminado con exito']); 
     } 
     
}

 

