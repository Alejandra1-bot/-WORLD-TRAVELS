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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8',
            'email_verified_at' => 'nullable|date',
            'roles'=>'required|string|in:admin,usuarios' // rol puede ser admin o usuarios
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $usuarios = Usuarios::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // hash hace que la contraseña no se vea en texto plano
            'roles'=> $request->roles,
        ]);

        try{
            $token = JWTAuth::fromUsuarios($usuarios);  
            return response()->json([
            'success' => true,
            'Usuarios' => $usuarios,
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
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
               'success' => false,
                'message' => 'Credenciales invalidas',
            ], 401);
        }  
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);     
   }

    public function logout(){
        try{
            $usuarios = JWTAuth::usuarios(); // validar el usuario logeado
            JWTAuth::invalidate(JWTAuth::getToken()); // invalidar el token
            return response()->json([
                'success' => true,
                'message' => $usuarios->name.' ha cerrado sesion correctamente',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => ' Error al  cerrar la sesion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function me ()
    {
        return response()->json([
            'success' => true,
            'usuarios' => JWTAuth::usuarios(),
        ], 200);
    }
    


}