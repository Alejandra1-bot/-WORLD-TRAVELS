<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios);
    }
    
   public function store(Request $request)
   {
        $validator = Validator::make($request->all(),[
        'Nombre'=> 'required|string',
        'Apellido'=> 'required|string',
        'Email'=> 'required|string',
        'Contraseña'=> 'required|string',
        'Telefono'=> 'required|string',
        'Nacionalidad'=> 'required|string',
        'Fecha_Registro'=> 'required|date',
        'Rol'=> 'required|string',
        ]);

        if ($validator-> fails()) {
          return response()->json($validator->errors(), 422);
         }

        $usuarios = Usuarios::create($validator->validated());
        return response()->json($usuarios,201);  
   } 

     public function show(string $id)   
     {
        $usuarios = Usuarios::find($id);

        if (!$usuarios) { 
            return response()->json(['menssage'=> 'Usuario no encontrado'], 404);
        }

        return response()->json($usuarios);
    }

    public function update(Request $request, string $id)  
     {
          $usuarios = Usuarios::find($id);

          if (!$usuarios) { 
            return response()->json(['menssage'=> 'Usuario no encontrado para editar '], 404);
        }

         $validator = Validator::make($request->all(),[
         'Nombre'=> 'string',
         'Apellido'=> 'string',
         'Email'=> 'string',
         'Contraseña'=> 'string',
         'Telefono'=> 'string',
         'Nacionalidad'=> 'string',
         'Fecha_Registro'=> 'date',
         'Rol'=> 'string',
        ]);
        

          if ($validator-> fails()) {
         return response()->json($validator->errors(), 422);
        }

        $usuarios->update($validator->validated());
        return response()->json($usuarios); 
    }

     public function destroy (string $id)
    {
         $usuarios = Usuarios::find($id);
          if (!$usuarios) { 
            return response()->json(['menssage'=> 'Usuario no encontrado para eliminar '], 404);
        }
          $usuarios->delete();
          return response()->json(['message' => 'Usuarios eliminado con exito']); 
    } 
     
}

