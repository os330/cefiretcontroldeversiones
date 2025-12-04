<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{
    /**
     * Mostrar página para buscar expedientes
     */
    public function buscar()
    {
        // Verificar sesión
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        return view('expedientes.buscar');
    }
    
    /**
     * Buscar expedientes por paciente
     */
    public function search(Request $request)
    {
        // Verificar sesión
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $query = $request->input('query');
        
        // Buscar pacientes que coincidan
        $pacientes = DB::table('usuario')
            ->where(function($q) use ($query) {
                $q->where('nombre', 'like', "%$query%")
                  ->orWhere('apaterno', 'like', "%$query%")
                  ->orWhere('amaterno', 'like', "%$query%")
                  ->orWhere('correo', 'like', "%$query%")
                  ->orWhere('telefono', 'like', "%$query%");
            })
            ->where('id_tipo_usuario', 2) // Solo pacientes (tipo 2)
            ->get();
        
        return view('expedientes.buscar', compact('pacientes', 'query'));
    }
    
    /**
     * Mostrar expediente de un paciente
     */
    public function show($id)
    {
        // Verificar sesión
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $paciente = DB::table('usuario')->where('id_usuario', $id)->first();
        
        if (!$paciente) {
            return redirect()->route('expedientes.buscar')
                ->with('error', 'Paciente no encontrado');
        }
        
        // Aquí puedes agregar más información del expediente
        // Por ahora solo mostramos datos del usuario
        
        return view('expedientes.show', compact('paciente'));
    }
}