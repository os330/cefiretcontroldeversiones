<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabitosHigienicosController extends Controller
{
    // Mostrar lista
    public function index()
    {
        $datos = DB::select("SELECT * FROM habitos_higien");
        return view('habitos_higien.index', compact('datos'));
    }

    // Formulario crear
    public function crear()
    {
        return view('habitos_higien.crear');
    }

    // Guardar
    public function guardar(Request $request)
    {
        DB::insert("INSERT INTO habitos_higien (banio, suenio, alimentacion, actividad_fisica) VALUES (?, ?, ?, ?)", [
            $request->banio,
            $request->suenio,
            $request->alimentacion,
            $request->actividad_fisica
        ]);

        return redirect()->route('habitos.index');
    }

    // Editar
    public function editar($id)
    {
        $dato = DB::selectOne("SELECT * FROM habitos_higien WHERE id_habitos = ?", [$id]);
        return view('habitos_higien.editar', compact('dato'));
    }

    // Actualizar
    public function actualizar(Request $request, $id)
    {
        DB::update("UPDATE habitos_higien SET banio = ?, suenio = ?, alimentacion = ?, actividad_fisica = ? WHERE id_habitos = ?", [
            $request->banio,
            $request->suenio,
            $request->alimentacion,
            $request->actividad_fisica,
            $id
        ]);

        return redirect()->route('habitos.index');
    }

    // Eliminar
    public function eliminar($id)
    {
        DB::delete("DELETE FROM habitos_higien WHERE id_habitos = ?", [$id]);
        return redirect()->route('habitos.index');
    }
}
