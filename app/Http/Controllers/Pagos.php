<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = DB::table('pago')
            ->join('cliente', 'pago.idcliente', '=', 'cliente.idcliente')
            ->select('pago.*', 'cliente.nombre as paciente')
            ->get();

        return view('pago.index', compact('pagos'));
    }

    public function crear()
    {
        $pacientes = DB::table('cliente')->get();
        return view('pago.crear', compact('pacientes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'idcliente' => 'required',
            'monto' => 'required|numeric',
            'fecha' => 'required'
        ]);

        DB::table('pago')->insert([
            'idcliente' => $request->idcliente,
            'monto' => $request->monto,
            'fecha' => $request->fecha
        ]);

        return redirect()->route('pagos');
    }

    public function eliminar($id)
    {
        DB::table('pago')->where('idpago', $id)->delete();
        return redirect()->route('pagos');
    }
}
