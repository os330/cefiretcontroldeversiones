<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnfermedadPatologicaController extends Controller
{
    public function index()
    {
        $datos = DB::table('enferm_patolog')->get();
        return view('enfermedad_patologica.index', compact('datos'));
    }

    public function crear()
    {
        return view('enfermedad_patologica.crear');
    }

    public function guardar(Request $request)
    {
        DB::table('enferm_patolog')->insert([
            'idcliente' => $request->idcliente,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'fecha_registro' => $request->fecha_registro ?? date('Y-m-d')
        ]);

        return redirect()->route('enfermedad_patologica.index');
    }

    public function editar($id)
    {
        $dato = DB::table('enferm_patolog')->where('id_enfermedad', $id)->first();
        return view('enfermedad_patologica.editar', compact('dato'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('enferm_patolog')->where('id_enfermedad', $id)->update([
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento
        ]);

        return redirect()->route('enfermedad_patologica.index');
    }

    public function eliminar($id)
    {
        DB::table('enferm_patolog')->where('id_enfermedad', $id)->delete();
        return redirect()->route('enfermedad_patologica.index');
    }
}
