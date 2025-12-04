<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{
    public function index()
    {
        // Validar sesión
        if (!Session::has('usuario_id')) {
            return redirect()->route('login');
        }

        return view('inicio.dashboard');
    }
}
