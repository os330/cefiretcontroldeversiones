<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CitaController extends Controller
{
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        // obtener todas las citas con información de paciente y fisioterapeuta
        $citas = DB::select("
            SELECT c.*, 
                   up.nombre as paciente_nombre, up.apaterno as paciente_apaterno,
                   uf.nombre as fisio_nombre, uf.apaterno as fisio_apaterno
            FROM cita c
            LEFT JOIN usuario up ON c.id_usuario = up.id_usuario
            LEFT JOIN usuario uf ON c.id_fisioterapeuta = uf.id_usuario
            ORDER BY c.fecha DESC, c.hora DESC
        ");

        // obtener fisioterapeutas disponibles
        $fisioterapeutas = DB::table('usuario')
            ->where('id_tipo_usuario', 2)
            ->orderBy('nombre')
            ->get();

        // obtener pacientes
        $pacientes = DB::table('usuario')
            ->where('id_tipo_usuario', 3)
            ->orderBy('nombre')
            ->get();

        return view('citas.index', compact('citas', 'fisioterapeutas', 'pacientes'));
    }

    public function create()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        // obtener fisioterapeutas
        $fisioterapeutas = DB::table('usuario')
            ->where('id_tipo_usuario', 2)
            ->orderBy('nombre')
            ->get();

        // obtener pacientes
        $pacientes = DB::table('usuario')
            ->where('id_tipo_usuario', 3)
            ->orderBy('nombre')
            ->get();

        return view('citas.create', compact('fisioterapeutas', 'pacientes'));
    }

    public function store(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        $request->validate([
            'id_usuario' => 'required|integer',
            'id_fisioterapeuta' => 'required|integer',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string',
            'estatus' => 'required|in:pendiente,confirmada,cancelada,completada'
        ]);

        try {
            $citaExistente = DB::table('cita')
                ->where('id_fisioterapeuta', $request->id_fisioterapeuta)
                ->where('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->where('estatus', '!=', 'cancelada')
                ->first();

            if ($citaExistente) {
                return redirect()->back()
                    ->with('error', 'El fisioterapeuta ya tiene una cita programada para esa fecha y hora')
                    ->withInput();
            }

            // insertar nueva cita
            DB::table('cita')->insert([
                'id_usuario' => $request->id_usuario,
                'id_fisioterapeuta' => $request->id_fisioterapeuta,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'observaciones' => $request->observaciones,
                'estatus' => $request->estatus,
            ]);

            return redirect()->route('citas.index')
                ->with('success', 'Cita agendada exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        $cita = DB::table('cita')
            ->where('id_cita', $id)
            ->first();

        if (!$cita) {
            return redirect()->route('citas.index')
                ->with('error', 'Cita no encontrada');
        }

        $fisioterapeutas = DB::table('usuario')
            ->where('id_tipo_usuario', 2)
            ->orderBy('nombre')
            ->get();

        $pacientes = DB::table('usuario')
            ->where('id_tipo_usuario', 3)
            ->orderBy('nombre')
            ->get();

        return view('citas.edit', compact('cita', 'fisioterapeutas', 'pacientes'));
    }

    public function update(Request $request, $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        $request->validate([
            'id_usuario' => 'required|integer',
            'id_fisioterapeuta' => 'required|integer',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string',
            'estatus' => 'required|in:pendiente,confirmada,cancelada,completada'
        ]);

        try {
            $citaExistente = DB::table('cita')
                ->where('id_fisioterapeuta', $request->id_fisioterapeuta)
                ->where('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->where('id_cita', '!=', $id)
                ->where('estatus', '!=', 'cancelada')
                ->first();

            if ($citaExistente) {
                return redirect()->back()
                    ->with('error', 'El fisioterapeuta ya tiene una cita programada para esa fecha y hora')
                    ->withInput();
            }

            // actualizar cita
            DB::table('cita')
                ->where('id_cita', $id)
                ->update([
                    'id_usuario' => $request->id_usuario,
                    'id_fisioterapeuta' => $request->id_fisioterapeuta,
                    'fecha' => $request->fecha,
                    'hora' => $request->hora,
                    'motivo' => $request->motivo,
                    'observaciones' => $request->observaciones,
                    'estatus' => $request->estatus,
                ]);

            return redirect()->route('citas.index')
                ->with('success', 'Cita actualizada exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function cancelar($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {
            DB::table('cita')
                ->where('id_cita', $id)
                ->update(['estatus' => 'cancelada']);

            return redirect()->route('citas.index')
                ->with('success', 'Cita cancelada exitosamente');

        } catch (\Exception $e) {
            return redirect()->route('citas.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {
            DB::table('cita')
                ->where('id_cita', $id)
                ->delete();

            return redirect()->route('citas.index')
                ->with('success', 'Cita eliminada exitosamente');

        } catch (\Exception $e) {
            return redirect()->route('citas.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function getHorariosDisponibles(Request $request)
    {
        $request->validate([
            'id_fisioterapeuta' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        try {
            $horariosDisponibles = [
                '09:00', '10:00', '11:00', '12:00', 
                '13:00', '14:00', '15:00', '16:00', '17:00'
            ];
            $citasAgendadas = DB::table('cita')
                ->where('id_fisioterapeuta', $request->id_fisioterapeuta)
                ->where('fecha', $request->fecha)
                ->where('estatus', '!=', 'cancelada')
                ->pluck('hora')
                ->toArray();

            $horariosDisponibles = array_diff($horariosDisponibles, $citasAgendadas);

            return response()->json([
                'success' => true,
                'horarios' => array_values($horariosDisponibles)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function disponibilidad()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        $fisioterapeutas = DB::table('usuario')
            ->where('id_tipo_usuario', 2)
            ->orderBy('nombre')
            ->get();

        return view('citas.disponibilidad', compact('fisioterapeutas'));
    }

    public function getCitasPorFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        try {
            $citas = DB::select("
                SELECT c.*, 
                       up.nombre as paciente_nombre, up.apaterno as paciente_apaterno,
                       uf.nombre as fisio_nombre
                FROM cita c
                LEFT JOIN usuario up ON c.id_usuario = up.id_usuario
                LEFT JOIN usuario uf ON c.id_fisioterapeuta = uf.id_usuario
                WHERE c.fecha = ?
                ORDER BY c.hora ASC
            ", [$request->fecha]);

            return response()->json([
                'success' => true,
                'citas' => $citas
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}