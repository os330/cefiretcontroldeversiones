<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Guardar nuevo usuario (VERSIÓN QUE SÍ FUNCIONA)
    public function store(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|string|max:15',
            'fecha_nac' => 'required|date',
            'contrasena' => 'required|min:6'
        ]);
        
        try {
            // OBTENER EL SIGUIENTE ID MANUALMENTE
            $maxId = DB::table('usuario')->max('id_usuario');
            $nextId = ($maxId ? $maxId + 1 : 1);
            
            // INSERTAR CON id_usuario EXPLÍCITO
            DB::table('usuario')->insert([
                'id_usuario' => $nextId,  // ← ESTA ES LA CLAVE
                'nombre' => $request->nombre,
                'apaterno' => $request->apaterno,
                'amaterno' => $request->amaterno,
                'correo' => $request->correo,
                'contrasena' => Hash::make($request->contrasena),
                'telefono' => $request->telefono,
                'fecha_nac' => $request->fecha_nac,
                'id_tipo_usuario' => 2
            ]);
            
            return redirect()->route('usuarios.create')
                ->with('success', 'Usuario registrado exitosamente (ID: ' . $nextId . ')');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar: ' . $e->getMessage()]);
        }
    }
    
    // Las demás funciones las mantienes igual...
    public function create()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        return view('usuarios.create');
    }
    
    public function buscar()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        return view('usuarios.buscar');
    }
    
    public function search(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $query = $request->input('query');
        
        $usuarios = DB::table('usuario')
            ->where('nombre', 'like', "%$query%")
            ->orWhere('apaterno', 'like', "%$query%")
            ->orWhere('amaterno', 'like', "%$query%")
            ->orWhere('correo', 'like', "%$query%")
            ->orWhere('telefono', 'like', "%$query%")
            ->get();
        
        return view('usuarios.buscar', compact('usuarios', 'query'));
    }
    
    public function edit($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $usuario = DB::table('usuario')->where('id_usuario', $id)->first();
        
        if (!$usuario) {
            return redirect()->route('usuarios.buscar')
                ->with('error', 'Usuario no encontrado');
        }
        
        return view('usuarios.edit', compact('usuario'));
    }
    
    public function update(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo,' . $id . ',id_usuario',
            'telefono' => 'required|string|max:15',
            'fecha_nac' => 'required|date'
        ]);
        
        DB::table('usuario')
            ->where('id_usuario', $id)
            ->update([
                'nombre' => $request->nombre,
                'apaterno' => $request->apaterno,
                'amaterno' => $request->amaterno,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'fecha_nac' => $request->fecha_nac
            ]);
        
        return redirect()->route('usuarios.buscar')
            ->with('success', 'Usuario actualizado exitosamente');
    }
}