<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToxicomaniasController extends Controller
{
    public function index()
    {
        $datos = DB::select("SELECT * FROM toxicomania");
        return view('toxicomanias.index', compact('datos'));
    }

    public function crear()
    {
        return view('toxicomanias.crear');
    }

    public function guardar(Request $request)
    {
        DB::insert("INSERT INTO toxicomania (alcohol, tabaco, drogas, frecuencia) VALUES (?, ?, ?, ?)", [
            $request->alcohol,
            $request->tabaco,
            $request->drogas,
            $request->frecuencia,
        ]);

        return redirect()->route('toxicomanias.index');
    }

    public function editar($id)
    {
        $dato = DB::selectOne("SELECT * FROM toxicomania WHERE id_toxico = ?", [$id]);
        return view('toxicomanias.editar', compact('dato'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::update("UPDATE toxicomania SET alcohol = ?, tabaco = ?, drogas = ?, frecuencia = ? WHERE id_toxico = ?", [
            $request->alcohol,
            $request->tabaco,
            $request->drogas,
            $request->frecuencia,
            $id
        ]);

        return redirect()->route('toxicomanias.index');
    }

    public function eliminar($id)
    {
        DB::delete("DELETE FROM toxicomania WHERE id_toxico = ?", [$id]);
        return redirect()->route('toxicomanias.index');
    }
}
