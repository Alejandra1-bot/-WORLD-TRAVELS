<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:usuarios',
            'Contraseña' => 'required|string|min:8',
            'Telefono' => 'required|string|max:20',
            'Nacionalidad' => 'required|string|max:255',
            'Rol' => 'required|string|in:Turista,Guía Turístico,Administrador'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $usuarios = Usuarios::create([
            'Nombre' => $request->Nombre,
            'Apellido' => $request->Apellido,
            'Email' => $request->Email,
            'Contraseña' => Hash::make($request->Contraseña),
            'Telefono' => $request->Telefono,
            'Nacionalidad' => $request->Nacionalidad,
            'Rol' => $request->Rol,
        ]);

        try{
            $token = JWTAuth::fromUser($usuarios);
            return response()->json([
            'success' => true,
            'usuario' => $usuarios,
            'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el Token JWT',
                'error' => $e->getMessage(),
            ], 500);

        }
    } 

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|string|email',
            'Contraseña' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $credentials = $request->only('Email', 'Contraseña');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
               'success' => false,
                 'message' => 'Credenciales inválidas',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(){
        try{
            $usuarios = JWTAuth::user(); // validar el usuario logeado
            JWTAuth::invalidate(JWTAuth::getToken()); // invalidar el token
            return response()->json([
                'success' => true,
                'message' => $usuarios->Nombre.' ha cerrado sesión correctamente',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la sesión',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function me ()
    {
        return response()->json([
            'success' => true,
            'usuario' => JWTAuth::user(),
        ], 200);
    }
    


}