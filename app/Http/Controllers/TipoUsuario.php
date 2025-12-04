<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoUsuarioController extends Controller
{
    public function index()
    {
        $tipos = DB::table('tipousuario')->get();
        return view('tipo_usuario.index', compact('tipos'));
    }

    public function crear()
    {
        return view('tipo_usuario.crear');
    }

    public function guardar(Request $request)
    {
        DB::table('tipousuario')->insert([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('tipo_usuario.index');
    }

    public function editar($id)
    {
        $tipo = DB::table('tipousuario')->where('id_tipousuario', $id)->first();
        return view('tipo_usuario.editar', compact('tipo'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('tipousuario')->where('id_tipousuario', $id)->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('tipo_usuario.index');
    }

    public function eliminar($id)
    {
        DB::table('tipousuario')->where('id_tipousuario', $id)->delete();
        return redirect()->route('tipo_usuario.index');
    }
}
