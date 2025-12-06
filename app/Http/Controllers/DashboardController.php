<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión primero');
        }

        $usuario = DB::table('usuario')
            ->where('id_usuario', session('user_id'))
            ->first(['nombre', 'apaterno', 'amaterno', 'correo', 'telefono', 'fecha_nac', 'id_tipo_usuario']);

        return view('dashboard.index', [
            'usuario' => $usuario
        ]);
    }
}