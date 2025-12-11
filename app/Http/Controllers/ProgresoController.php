<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresoController extends Controller
{
    public function index($idPaciente)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {
            $paciente = DB::table('usuario')
                ->where('id_usuario', $idPaciente)
                ->where('id_tipo_usuario', 3)
                ->first();

            if (!$paciente) {
                return back()->with('error', 'Paciente no encontrado');
            }

            $progresos = DB::table('progreso')
                ->where('id_usuario', $idPaciente)
                ->orderBy('fecha', 'desc')
                ->get();

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar el progreso del paciente: ' . $e->getMessage());
        }
        return view('progreso.index', compact('paciente', 'progresos'));
    }

    public function registrar($idPaciente)
    {
        try {

            return view('progreso.registrar', compact('idPaciente'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function guardar(Request $request, $idPaciente)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        $request->validate([
            'descripcion' => 'required|string|max:500',
            'fecha' => 'required|date'
        ]);

        try {

            DB::table('progreso')->insert([
                'id_usuario'   => $idPaciente,
                'descripcion'  => $request->descripcion,
                'fecha'        => $request->fecha
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar el progreso: ' . $e->getMessage());
        }

        return redirect()->route('progreso', $idPaciente)
            ->with('success', 'Progreso registrado correctamente');
    }
}
