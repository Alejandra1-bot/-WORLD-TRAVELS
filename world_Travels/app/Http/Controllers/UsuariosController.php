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
        'Nombre'=> 'required|string|max:255',
        'Apellido'=> 'required|string|max:255',
        'Email'=> 'required|string|email|max:255|unique:usuarios',
        'Contraseña'=> 'required|string|min:8',
        'Telefono'=> 'required|string|max:20',
        'Nacionalidad'=> 'required|string|max:255',
        'Rol'=> 'required|string|in:Turista,Guía Turístico,Administrador',
        ]);

        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
         }

        $data = $validator->validated();
        $data['Contraseña'] = bcrypt($data['Contraseña']);
        $usuarios = Usuarios::create($data);
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
         'Nombre'=> 'string|max:255',
         'Apellido'=> 'string|max:255',
         'Email'=> 'string|email|max:255|unique:usuarios,email,'.$id,
         'Contraseña'=> 'string|min:8',
         'Telefono'=> 'string|max:20',
         'Nacionalidad'=> 'string|max:255',
         'Rol'=> 'string|in:Turista,Guía Turístico,Administrador',
        ]);
        

          if ($validator-> fails()) {
         return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();
        if (isset($data['Contraseña'])) {
            $data['Contraseña'] = bcrypt($data['Contraseña']);
        }
        $usuarios->update($data);
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

