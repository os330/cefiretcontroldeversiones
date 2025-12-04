<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntecedentePatologicoController extends Controller
{
    // Mostrar lista de antecedentes patológicos
    public function index()
    {
        $antecedentes = DB::table('anteced_patolog')->get();
        return view('antecedente_patologico.index', compact('antecedentes'));
    }

    // Formulario crear
    public function crear()
    {
        return view('antecedente_patologico.crear');
    }

    // Guardar
    public function guardar(Request $request)
    {
        $request->validate([
            'idcliente' => 'required',
            'descripcion' => 'required'
        ]);

        DB::table('anteced_patolog')->insert([
            'idcliente' => $request->idcliente,
            'descripcion' => $request->descripcion,
            'fecha_registro' => $request->fecha_registro ?? date('Y-m-d')
        ]);

        return redirect()->route('antecedentes_patolog.index');
    }

    // Editar
    public function editar($id)
    {
        $antecedente = DB::table('anteced_patolog')->where('id_antecedente', $id)->first();
        return view('antecedente_patologico.editar', compact('antecedente'));
    }

    // Actualizar
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required'
        ]);

        DB::table('anteced_patolog')->where('id_antecedente', $id)->update([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('antecedentes_patolog.index');
    }

    // Eliminar
    public function eliminar($id)
    {
        DB::table('anteced_patolog')->where('id_antecedente', $id)->delete();
        return redirect()->route('antecedentes_patolog.index');
    }
}
