<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function mostrarLogin()
    {
        return view('aut.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $usuario = DB::table('usuario')
            ->where('correo', $email)
            ->first();

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        if ($usuario->contrasena !== $password) {
            return redirect()->back()->with('error', 'Contraseña incorrecta');
        }

        Session::put('usuario_id', $usuario->id_usuario);
        Session::put('tipo_usuario', $usuario->id_tipo_usuario);
        Session::put('nombre', $usuario->nombre);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login.form');
    }
}