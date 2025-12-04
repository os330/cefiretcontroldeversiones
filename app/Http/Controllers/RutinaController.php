<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RutinaController extends Controller
{
    /**
     * Mostrar lista de rutinas
     */
    public function index()
    {
        // Verificar sesión
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        // Por ahora mostramos una vista básica
        return view('rutinas.index');
    }
    
    /**
     * Crear nueva rutina
     */
    public function create()
    {
        // Verificar sesión
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        return view('rutinas.create');
    }
    
    /**
     * Guardar rutina
     */
    public function store(Request $request)
    {
        // Verificar sesión
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'duracion' => 'required|integer|min:1',
            'frecuencia' => 'required|string'
        ]);
        
        // Aquí iría la lógica para guardar la rutina en la base de datos
        // Por ahora solo redirigimos con mensaje de éxito
        
        return redirect()->route('rutinas.index')
            ->with('success', 'Rutina creada exitosamente');
    }
}