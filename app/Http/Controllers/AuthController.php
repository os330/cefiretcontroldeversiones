<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // buscar usuario por correo
        $user = DB::table('usuario')
            ->where('correo', $request->email)
            ->first();
        
        if ($user) {
            // verificar contraseña
            $passwordValid = false;
            $password = $user->contrasena;
            
            if (strlen($password) === 60 && strpos($password, '$2y$') === 0) {
                $passwordValid = Hash::check($request->password, $password);
            } else {
                $passwordValid = ($password === $request->password);
                if ($passwordValid) {
                    DB::table('usuario')
                        ->where('id_usuario', $user->id_usuario)
                        ->update(['contrasena' => Hash::make($request->password)]);
                }
            }
            
            if ($passwordValid) {
                // crear nombre completo
                $nombreCompleto = trim($user->nombre . ' ' . $user->apaterno . ' ' . $user->amaterno);
                
                // crear sesion
                session([
                    'user_id' => $user->id_usuario,
                    'user_nombre' => $nombreCompleto,
                    'user_email' => $user->correo,
                    'user_tipo' => $user->id_tipo_usuario,
                    'logged_in' => true
                ]);
                
                return redirect()->route('dashboard')->with('success', '¡Bienvenido ' . $user->nombre . '!');
            }
        }
        
        return back()->withErrors(['email' => 'Correo o contraseña incorrectos']);
    }
    
    // cerrar sesion
    public function logout()
    {
        session()->flush();
        return redirect()->route('login.form')->with('success', 'Sesión cerrada correctamente');
    }
}