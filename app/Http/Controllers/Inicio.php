<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{
    public function index()
    {
        if (!Session::has('usuario_id')) {
            return redirect()->route('login');
        }

        return view('inicio.dashboard');
    }
}
