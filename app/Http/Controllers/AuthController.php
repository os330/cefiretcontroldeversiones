<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        // Si ya tiene sesión, ir al dashboard
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    
    // Procesar login
    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Buscar usuario por correo
        $user = DB::table('usuario')
            ->where('correo', $request->email)
            ->first();
        
        if ($user) {
            // Verificar contraseña (compatible con texto plano y bcrypt)
            $passwordValid = false;
            $password = $user->contrasena;
            
            // Si es bcrypt (60 caracteres, empieza con $2y$)
            if (strlen($password) === 60 && strpos($password, '$2y$') === 0) {
                $passwordValid = Hash::check($request->password, $password);
            } else {
                // Si es texto plano, comparar directamente
                $passwordValid = ($password === $request->password);
                
                // Si funciona y es texto plano, convertir a bcrypt
                if ($passwordValid) {
                    DB::table('usuario')
                        ->where('id_usuario', $user->id_usuario)
                        ->update(['contrasena' => Hash::make($request->password)]);
                }
            }
            
            if ($passwordValid) {
                // Crear nombre completo
                $nombreCompleto = trim($user->nombre . ' ' . $user->apaterno . ' ' . $user->amaterno);
                
                // Crear sesión
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
    
    // Cerrar sesión
    public function logout()
    {
        session()->flush();
        return redirect()->route('login.form')->with('success', 'Sesión cerrada correctamente');
    }
}