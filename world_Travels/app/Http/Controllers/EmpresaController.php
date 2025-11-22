<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    /**
     * Listar todas las empresas
     * - Recupera todos los registros de la tabla empresas.
     * - Retorna la colección en formato JSON.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    /**
     * Crear una nueva empresa
     * - Valida los datos recibidos en la petición.
     * - Si la validación falla, retorna un error 422 con los mensajes.
     * - Si pasa la validación, crea un nuevo registro en la base de datos.
     * - Devuelve la empresa creada con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'     => 'required|string|max:255',
            'nit'        => 'required|string|max:50|unique:empresas,nit',
            'direccion'  => 'required|string|max:255',
            'ciudad'     => 'required|string|max:100',
            'email'     => 'required|email|unique:empresas,email',
            'telefono'   => 'nullable|string|max:20',
            'contraseña' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Encriptar contraseña antes de guardar
        $validatedData = $validator->validated();
        $validatedData['contraseña'] = Hash::make($validatedData['contraseña']);

        // Crear usuario en la tabla users
        $user = User::create([
            'name' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'password' => $validatedData['contraseña'],
            'role' => 'empresa',
            'nit' => $validatedData['nit'],
            'direccion' => $validatedData['direccion'],
            'ciudad' => $validatedData['ciudad'],
        ]);

        // Crear empresa
        $empresa = Empresa::create($validatedData);
        return response()->json($empresa, 201);
    }
    /**
     * Login de empresa
     * - Valida las credenciales.
     * - Si son válidas, genera un token JWT.
     * - Retorna el token y datos de la empresa.
     * 
     */
    public function login(Request $request)
      {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'contraseña' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->contraseña,
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $empresa = auth('api')->user();

        return response()->json([
            'token' => $token,
            'empresa' => $empresa,
        ]);
    }

    /**
     * Mostrar una empresa específica
     * - Busca la empresa por ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, devuelve la empresa en formato JSON.
     */
    public function show(string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json($empresa);
    }

    /**
     * Actualizar una empresa existente
     * - Busca la empresa por ID.
     * - Si no existe, retorna un error 404.
     * - Valida los datos recibidos (opcionales).
     * - Si son válidos, actualiza el registro en la base de datos.
     * - Retorna la empresa actualizada.
     */
    public function update(Request $request, string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'     => 'string|max:255',
            'nit'        => 'string|max:50|unique:empresas,nit,' . $id,
            'direccion'  => 'string|max:255',
            'ciudad'     => 'string|max:100',
            'email'     => 'email|unique:empresas,email,' . $id,
            'telefono'   => 'nullable|string|max:20',
            'contraseña' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $oldEmail = $empresa->email;
        $oldNombre = $empresa->nombre;

        $validatedData = $validator->validated();

        // Si se envía nueva contraseña, encriptarla
        if (isset($validatedData['contraseña'])) {
            $validatedData['contraseña'] = Hash::make($validatedData['contraseña']);
        }

        DB::transaction(function () use ($empresa, $validatedData, $oldEmail, $oldNombre) {
            $empresa->update($validatedData);

            // Actualizar también en tabla users
            $user = User::where('email', $oldEmail)->first();
            if ($user) {
                $userData = [];
                if (isset($validatedData['nombre'])) {
                    $userData['name'] = $validatedData['nombre'];
                }
                if (isset($validatedData['email'])) {
                    $userData['email'] = $validatedData['email'];
                }
                if (isset($validatedData['nit'])) {
                    $userData['nit'] = $validatedData['nit'];
                }
                if (isset($validatedData['direccion'])) {
                    $userData['direccion'] = $validatedData['direccion'];
                }
                if (isset($validatedData['ciudad'])) {
                    $userData['ciudad'] = $validatedData['ciudad'];
                }
                if (isset($validatedData['contraseña'])) {
                    $userData['password'] = $validatedData['contraseña'];
                }

                if (!empty($userData)) {
                    Log::info('Updating user with data: ' . json_encode($userData));
                    $user->update($userData);
                }
            }
        });

        return response()->json($empresa);
    }

    /**
     * Eliminar una empresa
     * - Busca la empresa por ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Retorna un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada para eliminar'], 404);
        }

        $empresa->delete();
        return response()->json(['message' => 'Empresa eliminada con éxito']);
    }
}
