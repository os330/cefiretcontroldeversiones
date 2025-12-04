<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresoController extends Controller
{
    public function index($idPaciente)
    {
        $paciente = DB::table('cliente')->where('idcliente', $idPaciente)->first();

        $progresos = DB::table('progreso')
            ->where('idcliente', $idPaciente)
            ->get();

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

        DB::table('progreso')->insert([
            'idcliente' => $idPaciente,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha
        ]);

        return redirect()->route('progreso', $idPaciente);
    }
}
