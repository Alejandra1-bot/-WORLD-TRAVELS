<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\CodigoVerificacionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            'Rol' => 'required|string|in:Turista,Guía Turístico,Administrador',
            'codigo_verificacion' => 'nullable|string|size:6'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Si es Guía Turístico, verificar el código de verificación
        if ($request->Rol === 'Guía Turístico') {
            if (!$request->has('codigo_verificacion') || empty($request->codigo_verificacion)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código de verificación es requerido para guías turísticos',
                ], 422);
            }

            $usuarioExistente = Usuarios::where('Email', $request->Email)->first();
            if (!$usuarioExistente || !$usuarioExistente->codigo_verificacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes solicitar un código de verificación primero',
                ], 422);
            }
            if ($request->codigo_verificacion !== $usuarioExistente->codigo_verificacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código de verificación incorrecto',
                ], 422);
            }
        }

        $usuarios = Usuarios::create([
            'Nombre' => $request->Nombre,
            'Apellido' => $request->Apellido,
            'Email' => $request->Email,
            'Contraseña' => Hash::make($request->Contraseña),
            'Telefono' => $request->Telefono,
            'Nacionalidad' => $request->Nacionalidad,
            'Rol' => $request->Rol,
            'codigo_verificacion' => null, // Limpiar después del registro
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

    public function enviarCodigoVerificacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $codigo = $this->generarCodigoVerificacion($request->Email);

        try {
            Mail::to($request->Email)->send(new CodigoVerificacionMail($codigo));
            return response()->json([
                'success' => true,
                'message' => 'Código de verificación enviado al correo electrónico',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el código de verificación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function generarCodigoVerificacion($email)
    {
        // Generar un código de 6 caracteres alfanuméricos
        $codigo = strtoupper(Str::random(6));

        // Guardar el código en la base de datos (temporalmente)
        // En producción, podrías usar cache o una tabla temporal
        Usuarios::updateOrCreate(
            ['Email' => $email],
            ['codigo_verificacion' => $codigo]
        );

        return $codigo;
    }


}