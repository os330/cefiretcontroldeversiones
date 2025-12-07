<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    public function index()
    {
        $citas = DB::table('cita')
            ->join('usuario as paciente', 'cita.id_usuario', '=', 'paciente.id_usuario')
            ->join('usuario as fisio', 'cita.id_fisioterapeuta', '=', 'fisio.id_usuario')
            ->select(
                'cita.*',
                'paciente.nombre as paciente',
                'fisio.nombre as fisio'
            )
            ->orderBy('cita.fecha')
            ->orderBy('cita.hora')
            ->get();

        return view('cita.index', compact('citas'));
    }

    public function create()
    {
        $pacientes = DB::table('usuario')->where('id_tipo_usuario', 3)->get();
        $fisios = DB::table('usuario')->where('id_tipo_usuario', 2)->get();

        return view('cita.create', compact('pacientes', 'fisios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required',
            'fisioterapeuta_id' => 'required',
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);

        // validar disponibilidad
        $existe = DB::table('cita')
            ->where('id_fisioterapeuta', $request->fisioterapeuta_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($existe) {
            return back()->with('error', 'El fisioterapeuta ya tiene una cita en esa fecha y hora.');
        }

        // obtener el siguiente ID
        $maxId = DB::table('cita')->max('id_cita');
        $nextId = ($maxId ? $maxId + 1 : 1);

        DB::table('cita')->insert([
            'id_cita' => $nextId,
            'id_usuario' => $request->paciente_id,
            'id_fisioterapeuta' => $request->fisioterapeuta_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'motivo' => $request->motivo,
            'estatus' => 'programada',
        ]);

        return redirect()->route('cita.index')->with('success', 'Cita creada correctamente');
    }

    public function show($id)
    {
        $cita = DB::table('cita')->where('id_cita', $id)->first();
        return view('cita._detalles', compact('cita'));
    }

    public function edit($id)
    {
        $cita = DB::table('cita')->where('id_cita', $id)->first();
        $pacientes = DB::table('usuario')->where('id_tipo_usuario', 3)->get();
        $fisios = DB::table('usuario')->where('id_tipo_usuario', 2)->get();

        return view('cita.edit', compact('cita', 'pacientes', 'fisios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required',
            'fisioterapeuta_id' => 'required',
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);

        // validar disponibilidad
        $existe = DB::table('cita')
            ->where('id_cita', '!=', $id)
            ->where('id_fisioterapeuta', $request->fisioterapeuta_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($existe) {
            return back()->with('error', 'El fisioterapeuta ya tiene una cita en esa fecha y hora.');
        }

        DB::table('cita')
            ->where('id_cita', $id)
            ->update([
                'id_usuario' => $request->paciente_id,
                'id_fisioterapeuta' => $request->fisioterapeuta_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
            ]);

        return redirect()->route('cita.index')->with('success', 'Cita actualizada correctamente');
    }

    public function destroy($id)
    {
        DB::table('cita')->where('id_cita', $id)->delete();

        return redirect()->route('cita.index')
            ->with('success', 'Cita eliminada correctamente');
    }

     public function cancelar($id)
     {
          DB::table('cita')->where('id_cita', $id)->update(['estatus' => 'cancelada']);
          return redirect()->route('cita.index')->with('success', 'Cita cancelada correctamente');
     }

     public function disponibilidad(Request $request)
     {
        $fisio = $request->fisioterapeuta_id;
        $fecha = $request->fecha;

        $horas_ocupadas = DB::table('cita')
            ->where('id_fisioterapeuta', $fisio)
            ->where('fecha', $fecha)
            ->pluck('hora')
            ->toArray();

        $horas = [
            "09:00", "10:00", "11:00", "12:00",
            "14:00", "15:00", "16:00", "17:00"
        ];

        $disponibles = array_diff($horas, $horas_ocupadas);

        return view('cita.disponibilidad', compact('disponibles', 'fecha'));
    }

    public function events()
    {
        $rows = DB::table('cita')
            ->join('usuario as paciente', 'cita.id_usuario', '=', 'paciente.id_usuario')
            ->join('usuario as fisio', 'cita.id_fisioterapeuta', '=', 'fisio.id_usuario')
            ->select('cita.*', 'paciente.nombre as paciente', 'fisio.nombre as fisio')
            ->get();

        $events = [];
        foreach ($rows as $r) {
            $start = $r->fecha;
            if (!empty($r->hora)) {
                $hora = substr($r->hora, 0, 5);
                $start = $start . 'T' . $hora;
            }

            $title = ($r->paciente ?? '') . ' - ' . ($r->fisio ?? '');
            $events[] = [
                'id' => $r->id_cita,
                'title' => $title,
                'start' => $start,
                'extendedProps' => [
                    'motivo' => $r->motivo,
                    'estatus' => $r->estatus ?? 'programada'
                ],
                'color' => (isset($r->estatus) && $r->estatus === 'cancelada') ? '#ff9f89' : '#3788d8'
            ];
        }

        return response()->json($events);
    }
}
