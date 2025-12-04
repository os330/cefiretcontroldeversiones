<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicioMedicoController extends Controller
{
    public function index()
    {
        $servicios = DB::table('servicios_medi')->get();
        return view('servicio.index', compact('servicios'));
    }

    public function crear()
    {
        return view('servicio.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'costo' => 'required|numeric'
        ]);

        DB::table('servicios_medi')->insert([
            'nombre' => $request->nombre,
            'costo' => $request->costo
        ]);

        return redirect()->route('servicios');
    }

    public function editar($id)
    {
        $servicio = DB::table('servicios_medi')->where('idservicio', $id)->first();

        return view('servicio.editar', compact('servicio'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('servicios_medi')->where('idservicio', $id)->update([
            'nombre' => $request->nombre,
            'costo' => $request->costo
        ]);

        return redirect()->route('servicios');
    }

    public function eliminar($id)
    {
        DB::table('servicios_medi')->where('idservicio', $id)->delete();
        return redirect()->route('servicios');
    }
}
