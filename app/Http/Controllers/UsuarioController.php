<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function create()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        return view('usuarios.create');
    }
    
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
            'contrasena' => 'required|min:6',
            'id_tipo_usuario' => 'required|in:1,2,3'
        ]);
        
        try {
            // obtener el siguiente ID
            $maxId = DB::table('usuario')->max('id_usuario');
            $nextId = ($maxId ? $maxId + 1 : 1);
            
            // insertar usuario
            DB::table('usuario')->insert([
                'id_usuario' => $nextId,
                'nombre' => $request->nombre,
                'apaterno' => $request->apaterno,
                'amaterno' => $request->amaterno,
                'correo' => $request->correo,
                'contrasena' => Hash::make($request->contrasena),
                'telefono' => $request->telefono,
                'fecha_nac' => $request->fecha_nac,
                'id_tipo_usuario' => $request->id_tipo_usuario
            ]);
            
            // si es PACIENTE redirigir a formulario de expediente
            if ($request->id_tipo_usuario == 3) {
                return redirect()->route('expedientes.completar', $nextId)
                    ->with('success', 'Usuario paciente registrado. Complete el expediente médico.');
            }
            
            // si es administrador o fisioterapeuta, regresar al inicio
            return redirect()->route('usuarios.create')
                ->with('success', 'Usuario registrado exitosamente');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar: ' . $e->getMessage()]);
        }
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