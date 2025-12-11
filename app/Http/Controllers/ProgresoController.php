<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresoController extends Controller
{
    public function index($idPaciente)
    {
        try {

            $paciente = DB::table('cliente')->where('idcliente', $idPaciente)->first();

            $progresos = DB::table('progreso')
                ->where('idcliente', $idPaciente)
                ->get();

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar el progreso del paciente: ' . $e->getMessage());
        }
        return view('progreso.index', compact('paciente', 'progresos'));
    }

    public function registrar($idPaciente)
    {
        return view('progreso.registrar', compact('idPaciente'));
    }

    public function guardar(Request $request, $idPaciente)
    {
        $request->validate([
            'descripcion' => 'required',
            'fecha' => 'required'
        ]);

        try {

            DB::table('progreso')->insert([
                'idcliente' => $idPaciente,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar el progreso: ' . $e->getMessage());
        }

        return redirect()->route('progreso', $idPaciente)
            ->with('success', 'Progreso registrado correctamente');
    }
}
