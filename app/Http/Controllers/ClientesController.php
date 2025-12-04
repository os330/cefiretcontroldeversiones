<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = DB::table('cliente')->get();
        return view('cliente.index', compact('clientes'));
    }

    public function crear()
    {
        return view('cliente.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'edad' => 'required|numeric',
            'telefono' => 'required'
        ]);

        DB::table('cliente')->insert([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'telefono' => $request->telefono
        ]);

        return redirect()->route('clientes');
    }

    public function editar($id)
    {
        $cliente = DB::table('cliente')->where('idcliente', $id)->first();
        return view('cliente.editar', compact('cliente'));
    }

    public function actualizar(Request $request, $id)
    {
        DB::table('cliente')->where('idcliente', $id)->update([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'telefono' => $request->telefono
        ]);

        return redirect()->route('clientes');
    }

    public function eliminar($id)
    {
        DB::table('cliente')->where('idcliente', $id)->delete();
        return redirect()->route('clientes');
    }
}
