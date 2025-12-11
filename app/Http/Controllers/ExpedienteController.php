<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{

    public function buscar()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        return view('expedientes.buscar');
    }

    public function search(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }
        
        $query = $request->input('query');

        try {

            $pacientes = DB::table('usuario')
                ->where(function($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%")
                      ->orWhere('apaterno', 'like', "%$query%")
                      ->orWhere('amaterno', 'like', "%$query%")
                      ->orWhere('correo', 'like', "%$query%")
                      ->orWhere('telefono', 'like', "%$query%");
                })
                ->where('id_tipo_usuario', 3)
                ->get();

        } catch (\Exception $e) {
            return back()->with('error', 'Error al buscar pacientes: ' . $e->getMessage());
        }
        
        return view('expedientes.buscar', compact('pacientes', 'query'));
    }

    public function show($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {

            $paciente = DB::table('usuario')->where('id_usuario', $id)->first();

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar expediente: ' . $e->getMessage());
        }
        
        if (!$paciente) {
            return redirect()->route('expedientes.buscar')
                ->with('error', 'Paciente no encontrado');
        }
        
        return view('expedientes.show', compact('paciente'));
    }
    
    public function completar($id_usuario)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {

            $paciente = DB::table('usuario')
                ->where('id_usuario', $id_usuario)
                ->where('id_tipo_usuario', 3)
                ->first();

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar datos del paciente: ' . $e->getMessage());
        }
        
        if (!$paciente) {
            return redirect()->route('usuarios.create')
                ->with('error', 'Paciente no encontrado');
        }
        
        return view('expedientes.completar', compact('paciente'));
    }
    
    public function guardarExpediente(Request $request, $id_usuario)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        $request->validate([
            'fecha_creacion' => 'required|date',
            'sexo' => 'required|string',
            'edad' => 'required|integer|min:0',
            'edo_civil' => 'required|string',
            'ocupacion' => 'required|string',
            'domicilio' => 'required|string',
            'colonia' => 'required|string',
            'municipio' => 'required|string',
            'lugar_nac' => 'required|string',
            'lugar_residencia' => 'required|string',
            'contacto_emergencia' => 'required|string',
            'nacionalidad' => 'required|string'
        ]);
        
        try {

            $maxIdExp = DB::table('expediente')->max('id_expediente');
            $nextIdExp = ($maxIdExp ? $maxIdExp + 1 : 1);

            DB::table('expediente')->insert([
                'id_expediente' => $nextIdExp, 
                'id_usuario' => $id_usuario,
                'fecha_creacion' => $request->fecha_creacion,
                'sexo' => $request->sexo,
                'edad' => $request->edad,
                'edo_civil' => $request->edo_civil,
                'ocupacion' => $request->ocupacion,
                'domicilio' => $request->domicilio,
                'colonia' => $request->colonia,
                'municipio' => $request->municipio,
                'lugar_nac' => $request->lugar_nac,
                'lugar_residencia' => $request->lugar_residencia,
                'contacto_emergencia' => $request->contacto_emergencia,
                'nacionalidad' => $request->nacionalidad,
                'religion' => $request->religion,
                'escolaridad' => $request->escolaridad,
                'presion_arterial' => substr($request->presion_arterial, 0, 50),
                'frec_cardiaca' => substr($request->frec_cardiaca, 0, 50),
                'llenado_capilar' => substr($request->llenado_capilar, 0, 50),
                'glucosa' => substr($request->glucosa, 0, 50),
                'frec_respiratoria' => substr($request->frec_respiratoria, 0, 50),
                'alimentacion' => substr($request->alimentacion, 0, 100)
            ]);

            $maxIdHab = DB::table('habitos_higien')->max('id_habitos');
            $nextIdHab = ($maxIdHab ? $maxIdHab + 1 : 1);
            
            DB::table('habitos_higien')->insert([
                'id_habitos' => $nextIdHab,
                'id_expediente' => $nextIdExp,
                'bano' => substr($request->bano, 0, 100),
                'lavado_manos' => substr($request->lavado_manos, 0, 100),
                'lavado_dientes' => substr($request->lavado_dientes, 0, 100),
                'cambio_ropa' => substr($request->cambio_ropa, 0, 100),
                'revision_pies' => substr($request->revision_pies, 0, 100),
                'horas_sueno' => substr($request->horas_sueno, 0, 100)
            ]);
            
            $maxIdViv = DB::table('vivienda')->max('id_vivienda');
            $nextIdViv = ($maxIdViv ? $maxIdViv + 1 : 1);
            
            DB::table('vivienda')->insert([
                'id_vivienda' => $nextIdViv,
                'id_expediente' => $nextIdExp,
                'detalles' => $request->vivienda_detalles,
                'techo' => substr($request->techo, 0, 100),
                'paredes' => substr($request->paredes, 0, 100),
                'suelo' => substr($request->suelo, 0, 100),
                'agua' => substr($request->agua, 0, 100),
                'luz' => substr($request->luz, 0, 100),
                'drenaje' => substr($request->drenaje, 0, 100),
                'gas' => substr($request->gas, 0, 100),
                'limpieza_hogar' => substr($request->limpieza_hogar, 0, 100)
            ]); 
            
            return redirect()->route('usuarios.create')
                ->with('success', 'Expediente clínico completado exitosamente (ID: ' . $nextIdExp . ')');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al guardar expediente: ' . $e->getMessage()]);
        }
    }
}
