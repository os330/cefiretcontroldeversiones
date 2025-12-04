<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViviendaController extends Controller
{
    public function index()
    {
        $viviendas = DB::table('vivienda')->get();
        return view('vivienda.index', compact('viviendas'));
    }

    public function crear()
    {
        return view('vivienda.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'servicios' => 'required'
        ]);

        DB::table('vivienda')->insert([
            'tipo' => $request->tipo,
            'servicios' => $request->servicios
        ]);

        return redirect()->route('viviendas');
    }

    public function editar($id)
    {
        $vivienda = DB::table('vivienda')->where('idvivienda', $id)->first();
        return view('vivienda.editar', compact('vivienda'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('vivienda')->where('idvivienda', $id)->update([
            'tipo' => $request->tipo,
            'servicios' => $request->servicios
        ]);

        return redirect()->route('viviendas');
    }

    public function eliminar($id)
    {
        DB::table('vivienda')->where('idvivienda', $id)->delete();
        return redirect()->route('viviendas');
    }
}
