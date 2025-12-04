<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntecedenteHeredofController extends Controller
{
    public function index()
    {
        $antecedentes = DB::table('antecen_heredof')->get();
        return view('antecedente_heredof.index', compact('antecedentes'));
    }

    public function crear()
    {
        return view('antecedente_heredof.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'idcliente' => 'required',
            'descripcion' => 'required'
        ]);

        DB::table('antecen_heredof')->insert([
            'idcliente' => $request->idcliente,
            'descripcion' => $request->descripcion,
            'pariente' => $request->pariente ?? null,
            'fecha_registro' => $request->fecha_registro ?? date('Y-m-d')
        ]);

        return redirect()->route('antecedentes_heredof.index');
    }

    public function editar($id)
    {
        $antecedente = DB::table('antecen_heredof')->where('id_antecedente', $id)->first();
        return view('antecedente_heredof.editar', compact('antecedente'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required'
        ]);

        DB::table('antecen_heredof')->where('id_antecedente', $id)->update([
            'descripcion' => $request->descripcion,
            'pariente' => $request->pariente ?? null
        ]);

        return redirect()->route('antecedentes_heredof.index');
    }

    public function eliminar($id)
    {
        DB::table('antecen_heredof')->where('id_antecedente', $id)->delete();
        return redirect()->route('antecedentes_heredof.index');
    }
}
