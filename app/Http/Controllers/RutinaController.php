<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RutinaController extends Controller
{
    public function index()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form');
        }

        $rutinas = DB::table('rutina as r')
    ->join('expediente as e', 'r.id_expediente', '=', 'e.id_expediente')
    ->join('usuario as u', 'e.id_usuario', '=', 'u.id_usuario')
    ->leftJoin('rutinadetalles as rd', 'r.id_rutina', '=', 'rd.id_rutina')
    ->leftJoin('video as v', 'rd.id_video', '=', 'v.id_video')
    ->select(
        'r.id_rutina',
        'r.fecha_asignacion',
        'u.nombre',
        'u.apaterno',
        'u.amaterno',
        DB::raw('COALESCE(v.titulo, "") as video_titulo'),
        DB::raw('COALESCE(v.url, "") as video_url')
    )
    ->orderBy('r.fecha_asignacion', 'desc')
    ->get();


        $pacientes = DB::table('usuario')
            ->where('id_tipo_usuario', 3)
            ->get();

        return view('rutinas.index', compact('rutinas', 'pacientes'));
    }

    public function create()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form');
        }

        $pacientes = DB::table('usuario')
            ->where('id_tipo_usuario', 3)
            ->get();

        return view('rutinas.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form');
        }

        $request->validate([
            'id_paciente' => 'required|integer',
            'fecha_asignacion' => 'required|date',
            'video_titulo' => 'required|string',
            'video_url' => 'required|string',
            'repeticiones' => 'nullable|integer',
            'series' => 'nullable|integer',
            'tiempo' => 'nullable|integer',
            'observaciones' => 'nullable|string',
            'dias' => 'required|array|min:1'
        ]);

        try {
            // obtener o crear expediente
            $expediente = DB::table('expediente')
                ->where('id_usuario', $request->id_paciente)
                ->first();

            if (!$expediente) {
                $expedienteId = DB::table('expediente')->insertGetId([
                    'id_usuario' => $request->id_paciente,
                    'fecha_creacion' => now(),
                    'sexo' => 'No especificado',
                    'edad' => 0,
                    'edo_civil' => 'No especificado',
                    'ocupacion' => 'No especificado',
                    'alimentacion' => 'Regular'
                ]);
            } else {
                $expedienteId = $expediente->id_expediente;
            }

            // crear video
            $videoId = DB::table('video')->insertGetId([
                'titulo' => $request->video_titulo,
                'descripcion' => $request->video_descripcion ?? '',
                'url' => $request->video_url
            ]);

            // crear rutina
            $rutinaId = DB::table('rutina')->insertGetId([
                'fecha_asignacion' => $request->fecha_asignacion,
                'id_expediente' => $expedienteId
            ]);

            // crear detalle
            DB::table('rutinadetalles')->insert([
                'id_rutina' => $rutinaId,
                'id_video' => $videoId,
                'repeticiones' => $request->repeticiones,
                'series' => $request->series,
                'tiempo' => $request->tiempo,
                'observaciones' => $request->observaciones
            ]);

            // guardar dias
            foreach ($request->dias as $dia) {
                DB::table('rutina_dias')->insert([
                    'id_rutina' => $rutinaId,
                    'dia' => $dia
                ]);
            }

            return redirect()->route('rutinas.index')
                ->with('success', 'Rutina creada correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form');
        }

        $rutina = DB::table('rutina as r')
            ->join('expediente as e', 'r.id_expediente', '=', 'e.id_expediente')
            ->join('usuario as u', 'e.id_usuario', '=', 'u.id_usuario')
            ->leftJoin('rutinadetalles as rd', 'r.id_rutina', '=', 'rd.id_rutina')
            ->leftJoin('video as v', 'rd.id_video', '=', 'v.id_video')
            ->where('r.id_rutina', $id)
            ->select(
                'r.*',
                'u.id_usuario as paciente_id',
                'u.nombre',
                'u.apaterno',
                'rd.repeticiones',
                'rd.series',
                'rd.tiempo',
                'rd.observaciones',
                'v.id_video',
                'v.titulo',
                'v.descripcion',
                'v.url'
            )
            ->first();

        if (!$rutina) {
            return redirect()->route('rutinas.index')
                ->with('error', 'Rutina no encontrada.');
        }

        $diasRutina = DB::table('rutina_dias')
            ->where('id_rutina', $id)
            ->pluck('dia')
            ->toArray();

        return view('rutinas.edit', compact('rutina', 'diasRutina'));
    }

    public function update(Request $request, $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form');
        }

        try {
            $detalle = DB::table('rutinadetalles')
                ->where('id_rutina', $id)
                ->first();

            if (!$detalle) {
                return redirect()->back()->with('error', 'No existen detalles.');
            }

            // actualizar video
            DB::table('video')
                ->where('id_video', $detalle->id_video)
                ->update([
                    'titulo' => $request->video_titulo,
                    'descripcion' => $request->video_descripcion,
                    'url' => $request->video_url
                ]);

            // actualizar detalles
            DB::table('rutinadetalles')
                ->where('id_rutina', $id)
                ->update([
                    'repeticiones' => $request->repeticiones,
                    'series' => $request->series,
                    'tiempo' => $request->tiempo,
                    'observaciones' => $request->observaciones
                ]);

            // actualizar días
            DB::table('rutina_dias')
                ->where('id_rutina', $id)
                ->delete();

            foreach ($request->dias as $dia) {
                DB::table('rutina_dias')->insert([
                    'id_rutina' => $id,
                    'dia' => $dia
                ]);
            }

            return redirect()->route('rutinas.index')
                ->with('success', 'Rutina actualizada.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('rutina_dias')->where('id_rutina', $id)->delete();
            DB::table('rutinadetalles')->where('id_rutina', $id)->delete();
            DB::table('rutina')->where('id_rutina', $id)->delete();

            return redirect()->route('rutinas.index')
                ->with('success', 'Rutina eliminada.');
        } catch (\Exception $e) {
            return redirect()->route('rutinas.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function getRutinas()
    {
        try {
            $rutinas = DB::table('rutina as r')
                ->join('expediente as e', 'r.id_expediente', '=', 'e.id_expediente')
                ->join('usuario as u', 'e.id_usuario', '=', 'u.id_usuario')
                ->leftJoin('rutinadetalles as rd', 'r.id_rutina', '=', 'rd.id_rutina')
                ->leftJoin('video as v', 'rd.id_video', '=', 'v.id_video')
                ->select(
                    'r.id_rutina',
                    'r.fecha_asignacion',
                    'u.nombre',
                    'u.apaterno',
                    'v.titulo'
                )
                ->get();

            return response()->json([
                'success' => true,
                'rutinas' => $rutinas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login.form');
        }

        try {
            $rutina = DB::table('rutina as r')
                ->join('expediente as e', 'r.id_expediente', '=', 'e.id_expediente')
                ->join('usuario as u', 'e.id_usuario', '=', 'u.id_usuario')
                ->leftJoin('rutinadetalles as rd', 'r.id_rutina', '=', 'rd.id_rutina')
                ->leftJoin('video as v', 'rd.id_video', '=', 'v.id_video')
                ->where('r.id_rutina', $id)
                ->select(
                    'r.*',
                    'u.nombre',
                    'u.apaterno',
                    'u.amaterno',
                    'v.titulo',
                    'v.url',
                    'rd.repeticiones',
                    'rd.series',
                    'rd.tiempo',
                    'rd.observaciones'
                )
                ->first();

            if (!$rutina) {
                return redirect()->route('rutinas.index')->with('error', 'Rutina no encontrada');
            }

            $dias = DB::table('rutina_dias')
                ->where('id_rutina', $id)
                ->pluck('dia')
                ->toArray();

            return view('rutinas.detalles', compact('rutina', 'dias'));

        } catch (\Exception $e) {
            return redirect()->route('rutinas.index')->with('error', 'Error al cargar los detalles: ' . $e->getMessage());
        }
    }

    public function getRutinaDetalles($id)
    {
        try {
            $rutina = DB::table('rutina as r')
                ->join('expediente as e', 'r.id_expediente', '=', 'e.id_expediente')
                ->join('usuario as u', 'e.id_usuario', '=', 'u.id_usuario')
                ->leftJoin('rutinadetalles as rd', 'r.id_rutina', '=', 'rd.id_rutina')
                ->leftJoin('video as v', 'rd.id_video', '=', 'v.id_video')
                ->where('r.id_rutina', $id)
                ->select(
                    'r.*',
                    'u.nombre',
                    'u.apaterno',
                    'v.titulo',
                    'v.url',
                    'rd.repeticiones',
                    'rd.series',
                    'rd.tiempo',
                    'rd.observaciones'
                )
                ->first();

            if (!$rutina) {
                return response()->json(['error' => 'Rutina no encontrada'], 404);
            }

            $dias = DB::table('rutina_dias')
                ->where('id_rutina', $id)
                ->pluck('dia')
                ->toArray();

            $html = view('rutinas._detalles', compact('rutina', 'dias'))->render();

            return response()->json(['html' => $html]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function asignarExistente(Request $request)
{
    try {
        $request->validate([
            'id_paciente' => 'required|integer',
            'rutina_existente' => 'required|integer'
        ]);

        // buscar expediente del paciente
        $expediente = DB::table('expediente')
            ->where('id_usuario', $request->id_paciente)
            ->first();

        if (!$expediente) {
            return redirect()->back()->with('error', 'El paciente no tiene expediente.');
        }

        // duplicar la rutina
        $original = DB::table('rutina')->where('id_rutina', $request->rutina_existente)->first();
        $detalle = DB::table('rutinadetalles')->where('id_rutina', $request->rutina_existente)->first();
        $video   = DB::table('video')->where('id_video', $detalle->id_video)->first();
        $dias    = DB::table('rutina_dias')->where('id_rutina', $request->rutina_existente)->pluck('dia');

        // duplicar video
        $videoId = DB::table('video')->insertGetId([
            'titulo' => $video->titulo,
            'descripcion' => $video->descripcion,
            'url' => $video->url
        ]);

        // crear nueva rutina
        $newRutinaId = DB::table('rutina')->insertGetId([
            'fecha_asignacion' => now(),
            'id_expediente' => $expediente->id_expediente
        ]);

        // crear detalles de la rutina
        DB::table('rutinadetalles')->insert([
            'id_rutina' => $newRutinaId,
            'id_video' => $videoId,
            'repeticiones' => $detalle->repeticiones,
            'series' => $detalle->series,
            'tiempo' => $detalle->tiempo,
            'observaciones' => $detalle->observaciones
        ]);

        // guardar dias
        foreach ($dias as $dia) {
            DB::table('rutina_dias')->insert([
                'id_rutina' => $newRutinaId,
                'dia' => $dia
            ]);
        }

        return redirect()->route('rutinas.index')
            ->with('success', 'Rutina asignada correctamente.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

}

