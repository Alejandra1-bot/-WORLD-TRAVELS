<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservas;
use Illuminate\Support\Facades\Validator;

class ReservasController extends Controller
{
    // Listar todas las reservas
    public function index()
    {
        $reservas = Reservas::all();
        return response()->json($reservas);
    }

    // Crear una reserva
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUsuario'        => 'required|integer|exists:usuarios,id',
            'idActividad'      => 'required|integer|exists:actividad,id_actividad',
            'fechaReserva'     => 'required|date',
            'cantidadPersonas' => 'required|integer|min:1',
            'estado'           => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reserva = Reservas::create($validator->validated());
        return response()->json($reserva, 201);
    }

    // Mostrar una reserva por ID
    public function show(string $id)
    {
        $reserva = Reservas::find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        return response()->json($reserva);
    }

    // Actualizar una reserva
    public function update(Request $request, string $id)
    {
        $reserva = Reservas::find($id);

        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'idUsuario'        => 'sometimes|integer|exists:usuarios,id',
            'idActividad'      => 'sometimes|integer|exists:actividad,id_actividad',
            'fechaReserva'     => 'sometimes|date',
            'cantidadPersonas' => 'sometimes|integer|min:1',
            'estado'           => 'sometimes|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reserva->update($validator->validated());
        return response()->json($reserva);
    }

    // Eliminar una reserva
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
