<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EjercicioController extends Controller
{
    public function index()
    {
        $datos = DB::table('ejercicio')->get();
        return view('ejercicio.index', compact('datos'));
    }

    public function crear()
    {
        return view('ejercicio.crear');
    }

    public function guardar(Request $request)
    {
        DB::table('ejercicio')->insert([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'zona' => $request->zona
        ]);

        return redirect()->route('ejercicio.index');
    }

    public function editar($id)
    {
        $dato = DB::table('ejercicio')->where('id_ejercicio', $id)->first();
        return view('ejercicio.editar', compact('dato'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('ejercicio')->where('id_ejercicio', $id)->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'zona' => $request->zona
        ]);

        return redirect()->route('ejercicio.index');
    }

    public function eliminar($id)
    {
        DB::table('ejercicio')->where('id_ejercicio', $id)->delete();
        return redirect()->route('ejercicio.index');
    }
}
