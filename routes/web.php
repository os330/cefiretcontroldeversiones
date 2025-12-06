<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ProgresoController;

Route::get('/', function () {
    if (session()->has('user_id')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login.form');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::controller(UsuarioController::class)->group(function () {
    // Registrar usuario
    Route::get('/usuarios/crear', 'create')->name('usuarios.create');
    Route::post('/usuarios/crear', 'store')->name('usuarios.store');
    // Buscar usuarios
    Route::get('/usuarios/buscar', 'buscar')->name('usuarios.buscar');
    Route::post('/usuarios/buscar', 'search')->name('usuarios.search');
    // Editar usuario
    Route::get('/usuarios/editar/{id}', 'edit')->name('usuarios.edit');
    Route::post('/usuarios/actualizar/{id}', 'update')->name('usuarios.update');
});

Route::controller(ExpedienteController::class)->group(function () {
    // Buscar expedientes
    Route::get('/expedientes/buscar', 'buscar')->name('expedientes.buscar');
    Route::post('/expedientes/buscar', 'search')->name('expedientes.search');
    // Ver expediente
    Route::get('/expedientes/ver/{id}', 'show')->name('expedientes.show');
    // Completar expediente (NUEVAS RUTAS)
    Route::get('/expedientes/completar/{id}', 'completar')->name('expedientes.completar');
    Route::post('/expedientes/guardar/{id}', 'guardarExpediente')->name('expedientes.guardar');
});

Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
Route::get('/rutinas/crear', [RutinaController::class, 'create'])->name('rutinas.create');
Route::post('/rutinas', [RutinaController::class, 'store'])->name('rutinas.store');
Route::get('/rutinas/{id}/editar', [RutinaController::class, 'edit'])->name('rutinas.edit');
Route::get('/rutinas/{id}', [RutinaController::class, 'show'])->name('rutinas.show');
Route::put('/rutinas/{id}', [RutinaController::class, 'update'])->name('rutinas.update');
Route::delete('/rutinas/{id}', [RutinaController::class, 'destroy'])->name('rutinas.destroy');


Route::get('/rutinas/obtener', [RutinaController::class, 'getRutinas'])->name('rutinas.obtener');
Route::get('/rutinas/info/{id}', [RutinaController::class, 'getInfoRutina'])->name('rutinas.info');
Route::post('/rutinas/asignar', [RutinaController::class, 'asignar'])->name('rutinas.asignar');

Route::get('/rutinas/{id}/detalles', function ($id) {

    $rutina = DB::select("
        SELECT 
            r.id_rutina,
            r.fecha_asignacion,
            u.nombre,
            u.apaterno,
            d.repeticiones,
            d.series,
            d.tiempo,
            d.observaciones,
            COALESCE(v.titulo, '') AS titulo,
            COALESCE(v.url, '') AS url
        FROM rutina r
        JOIN rutinadetalles d ON d.id_rutina = r.id_rutina
        JOIN expediente e ON e.id_expediente = r.id_expediente
        JOIN usuario u ON u.id_usuario = e.id_usuario
        LEFT JOIN video v ON v.id_video = d.id_video
        WHERE r.id_rutina = ?
        LIMIT 1
    ", [$id]);

    if (!$rutina) {
        return '<div class="alert alert-danger">No se encontraron detalles de la rutina.</div>';
    }

    $rutina = $rutina[0];

    $dias = DB::table('rutina_dias')
        ->where('id_rutina', $id)
        ->pluck('dia')
        ->toArray();

    return view('rutinas._detalles', compact('rutina', 'dias'))->render();
});

Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
Route::get('/citas/{id}/editar', [CitaController::class, 'edit'])->name('citas.edit');
Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');
Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');
Route::post('/citas/{id}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');
Route::get('/citas/disponibilidad', [CitaController::class, 'disponibilidad'])->name('citas.disponibilidad');

Route::get('/citas/horarios-disponibles', [CitaController::class, 'getHorariosDisponibles']);
Route::get('/citas/disponibilidad-por-fecha', [CitaController::class, 'getCitasPorFecha']);
Route::get('/citas/{id}/detalles', function($id) {
    $cita = DB::select("
        SELECT c.*, 
               up.nombre as paciente_nombre, up.apaterno as paciente_apaterno,
               uf.nombre as fisio_nombre, uf.apaterno as fisio_apaterno
        FROM cita c
        LEFT JOIN usuario up ON c.id_usuario = up.id_usuario
        LEFT JOIN usuario uf ON c.id_fisioterapeuta = uf.id_usuario
        WHERE c.id_cita = ?
        LIMIT 1
    ", [$id]);

    if (empty($cita)) {
        return '<div class="alert alert-danger">Cita no encontrada</div>';
    }

    $cita = $cita[0];

    return view('citas._detalles', compact('cita'))->render();
});

Route::get('/progreso', [ProgresoController::class, 'index'])->name('progreso.index');  
Route::get('/progreso/{id_usuario}', [ProgresoController::class, 'show'])->name('progreso.show');
Route::post('/progreso/guardar', [ProgresoController::class, 'store'])->name('progreso.store');

Route::post('/rutinas/asignar-existente', [RutinaController::class, 'asignarExistente'])
    ->name('rutinas.asignarExistente');

Route::get('/rutinas/listar', [RutinaController::class, 'getRutinas'])
    ->name('rutinas.listar');
Route::get('/rutinas/{id}/progreso', [RutinaController::class, 'show'])
     ->name('rutinas.show');

     Route::get('/citas/horas-disponibles', [CitaController::class, 'horasDisponibles'])
    ->name('citas.horas');
