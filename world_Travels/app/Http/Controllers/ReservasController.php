<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservas;
use Illuminate\Support\Facades\Validator;

class ReservasController extends Controller
{
    /**
     * Listar todas las reservas
     * - Recupera todos los registros de la tabla reservas.
     * - Devuelve la colección completa en formato JSON.
     */
    public function index()
    {
        $reservas = Reservas::all();
        return response()->json($reservas);
    }

    /**
     * Crear una nueva reserva
     * - Valida los datos recibidos en la petición.
     * - Valida existencia de usuario y actividad en sus tablas correspondientes.
     * - Si falla la validación, retorna error 422 con detalles.
     * - Si pasa, guarda el registro en la base de datos.
     * - Devuelve la reserva creada con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUsuario'        => 'required|integer|exists:usuarios,id',
            'idActividad'      => 'required|integer|exists:actividades,id',
            'Fecha_Reserva'    => 'required|date',
            'Numero_Personas'  => 'required|integer|min:1',
            'Estado'           => 'required|string|in:pendiente,confirmada,cancelada',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reserva = Reservas::create($validator->validated());
        return response()->json($reserva, 201);
    }

    /**
     * Mostrar una reserva específica
     * - Busca una reserva por su ID.
     * - Si no existe, retorna error 404.
     * - Si existe, devuelve el registro en formato JSON.
     */
    public function show(string $id)
    {
        $reserva = Reservas::find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        return response()->json($reserva);
    }

    /**
     * Actualizar una reserva existente
     * - Busca la reserva por ID.
     * - Si no existe, devuelve error 404.
     * - Valida los datos recibidos (todos opcionales).
     * - Si falla la validación, retorna error 422.
     * - Si pasa, actualiza el registro en la base de datos.
     * - Retorna la reserva actualizada.
     */
    public function update(Request $request, string $id)
    {
        $reserva = Reservas::find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'idUsuario'        => 'integer|exists:usuarios,id',
            'idActividad'      => 'integer|exists:actividades,id',
            'Fecha_Reserva'    => 'date',
            'Numero_Personas'  => 'integer|min:1',
            'Estado'           => 'string|in:pendiente,confirmada,cancelada',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reserva->update($validator->validated());
        return response()->json($reserva);
    }

    /**
     * Eliminar una reserva
     * - Busca la reserva por ID.
     * - Si no existe, retorna error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Devuelve un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $reserva = Reservas::find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada para eliminar'], 404);
        }

        $reserva->delete();
        return response()->json(['message' => 'Reserva eliminada con éxito']);
    }
}
