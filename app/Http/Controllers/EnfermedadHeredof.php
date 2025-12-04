<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnfermedadHeredofController extends Controller
{
    public function index()
    {
        $datos = DB::table('enferm_heredof')->get();
        return view('enfermedad_heredof.index', compact('datos'));
    }

    public function crear()
    {
        return view('enfermedad_heredof.crear');
    }

    public function guardar(Request $request)
    {
        DB::table('enferm_heredof')->insert([
            'idcliente' => $request->idcliente,
            'enfermedad' => $request->enfermedad,
            'parentezco' => $request->parentezco,
            'fecha_registro' => date('Y-m-d')
        ]);

        return redirect()->route('enfermedad_heredof.index');
    }

    public function editar($id)
    {
        $dato = DB::table('enferm_heredof')->where('id_enfermedad', $id)->first();
        return view('enfermedad_heredof.editar', compact('dato'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('enferm_heredof')->where('id_enfermedad', $id)->update([
            'enfermedad' => $request->enfermedad,
            'parentezco' => $request->parentezco
        ]);

        return redirect()->route('enfermedad_heredof.index');
    }

    public function eliminar($id)
    {
        DB::table('enferm_heredof')->where('id_enfermedad', $id)->delete();
        return redirect()->route('enfermedad_heredof.index');
    }
}
