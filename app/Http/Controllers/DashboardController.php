<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // VERIFICAR SESIÓN MANUALMENTE
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión primero');
        }
        
        // Obtener datos del usuario
        $usuario = DB::table('usuario')
            ->where('id_usuario', session('user_id'))
            ->first(['nombre', 'apaterno', 'amaterno', 'correo', 'telefono', 'fecha_nac', 'id_tipo_usuario']);
        
        // NO buscar estadísticas de tablas que no existen
        // Solo usar datos del usuario
        return view('dashboard.index', [
            'usuario' => $usuario
        ]);
    }
}