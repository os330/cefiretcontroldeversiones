<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\PacienteRegistradoMailable;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function create(){
    if (!session()->has('user_id')) {
        return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
    }

    try {
        return view('usuarios.create');
    } catch (\Exception $e) {
        return redirect()->route('usuarios.buscar')
            ->with('error', 'Error al cargar la vista: ' . $e->getMessage());
    }
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

            // enviar correo solo al paciente
            if ($request->id_tipo_usuario == 3) {

                $nombreCompleto = $request->nombre . " " . $request->apaterno . " " . $request->amaterno;

                Mail::to($request->correo)
                    ->send(new PacienteRegistradoMailable(
                        $nombreCompleto,
                        $request->correo
                    ));

                return redirect()->route('expedientes.completar', $nextId)
                    ->with('success', 'Paciente registrado y correo enviado. Complete el expediente médico.');
            }

            return redirect()->route('usuarios.create')
                ->with('success', 'Usuario registrado exitosamente y correo enviado.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar: ' . $e->getMessage()]);
        }
    }

    public function buscar()
{
    if (!session()->has('user_id')) {
        return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
    }

    try {
        return view('usuarios.buscar');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al cargar la busqueda: ' . $e->getMessage());
    }
}


    public function search(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {
            $query = $request->input('query');

            $usuarios = DB::table('usuario')
                ->where('nombre', 'like', "%$query%")
                ->orWhere('apaterno', 'like', "%$query%")
                ->orWhere('amaterno', 'like', "%$query%")
                ->orWhere('correo', 'like', "%$query%")
                ->orWhere('telefono', 'like', "%$query%")
                ->get();

            return view('usuarios.buscar', compact('usuarios', 'query'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error al buscar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión');
        }

        try {
            $usuario = DB::table('usuario')->where('id_usuario', $id)->first();

            if (!$usuario) {
                return redirect()->route('usuarios.buscar')
                    ->with('error', 'Usuario no encontrado');
            }

            return view('usuarios.edit', compact('usuario'));

        } catch (\Exception $e) {
            return redirect()->route('usuarios.buscar')
                ->with('error', 'Error al cargar el usuario: ' . $e->getMessage());
        }
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

        try {

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

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}
