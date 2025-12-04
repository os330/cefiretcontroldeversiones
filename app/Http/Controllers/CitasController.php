<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitasController extends Controller
{
    public function index()
    {
        $citas = DB::table('cita')
            ->join('cliente', 'cita.idcliente', '=', 'cliente.idcliente')
            ->select('cita.*', 'cliente.nombre as paciente')
            ->get();

        return view('cita.index', compact('citas'));
    }

    public function crear()
    {
        $pacientes = DB::table('cliente')->get();
        return view('cita.crear', compact('pacientes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'idcliente' => 'required',
            'fecha' => 'required',
            'hora' => 'required'
        ]);

        DB::table('cita')->insert([
            'idcliente' => $request->idcliente,
            'fecha' => $request->fecha,
            'hora' => $request->hora
        ]);

        return redirect()->route('citas');
    }

    public function editar($id)
    {
        $cita = DB::table('cita')->where('idcita', $id)->first();
        $pacientes = DB::table('cliente')->get();

        return view('cita.editar', compact('cita', 'pacientes'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('cita')->where('idcita', $id)->update([
            'idcliente' => $request->idcliente,
            'fecha' => $request->fecha,
            'hora' => $request->hora
        ]);

        return redirect()->route('citas');
    }

    public function eliminar($id)
    {
        DB::table('cita')->where('idcita', $id)->delete();
        return redirect()->route('citas');
    }
}
