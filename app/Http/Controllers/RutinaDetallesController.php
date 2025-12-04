<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RutinaDetallesController extends Controller
{
    public function index($idRutina)
    {
        $rutina = DB::table('rutina')->where('idrutina', $idRutina)->first();

        $detalles = DB::table('rutinadetalles')
            ->where('idrutina', $idRutina)
            ->get();

        return view('rutinadetalle.index', compact('rutina', 'detalles'));
    }

    public function agregar($idRutina)
    {
        return view('rutinadetalle.agregar', compact('idRutina'));
    }

    public function guardar(Request $request, $idRutina)
    {
        $request->validate([
            'ejercicio' => 'required',
            'repeticiones' => 'required',
            'series' => 'required'
        ]);

        DB::table('rutinadetalles')->insert([
            'idrutina' => $idRutina,
            'ejercicio' => $request->ejercicio,
            'repeticiones' => $request->repeticiones,
            'series' => $request->series
        ]);

        return redirect()->route('detalles_rutina', $idRutina);
    }

    public function eliminar($id)
    {
        $detalle = DB::table('rutinadetalles')->where('idrutinadetalle', $id)->first();

        DB::table('rutinadetalles')->where('idrutinadetalle', $id)->delete();

        return redirect()->route('detalles_rutina', $detalle->idrutina);
    }
}
