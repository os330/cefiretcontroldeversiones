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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::controller(UsuarioController::class)->group(function () {

    Route::get('/usuarios/crear', 'create')->name('usuarios.create');
    Route::post('/usuarios/crear', 'store')->name('usuarios.store');

    Route::get('/usuarios/buscar', 'buscar')->name('usuarios.buscar');
    Route::post('/usuarios/buscar', 'search')->name('usuarios.search');

    Route::get('/usuarios/editar/{id}', 'edit')->name('usuarios.edit');
    Route::post('/usuarios/actualizar/{id}', 'update')->name('usuarios.update');
});

Route::controller(ExpedienteController::class)->group(function () {

    Route::get('/expedientes/buscar', 'buscar')->name('expedientes.buscar');
    Route::post('/expedientes/buscar', 'search')->name('expedientes.search');

    Route::get('/expedientes/ver/{id}', 'show')->name('expedientes.show');

    Route::get('/expedientes/completar/{id}', 'completar')->name('expedientes.completar');
    Route::post('/expedientes/guardar/{id}', 'guardarExpediente')->name('expedientes.guardar');
});

Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
Route::get('/rutinas/crear', [RutinaController::class, 'create'])->name('rutinas.create');
Route::post('/rutinas', [RutinaController::class, 'store'])->name('rutinas.store');
Route::get('/rutinas/{id}/editar', [RutinaController::class, 'edit'])->name('rutinas.edit');
Route::put('/rutinas/{id}', [RutinaController::class, 'update'])->name('rutinas.update');
Route::delete('/rutinas/{id}', [RutinaController::class, 'destroy'])->name('rutinas.destroy');

Route::get('/rutinas/obtener', [RutinaController::class, 'getRutinas'])->name('rutinas.obtener');
Route::get('/rutinas/info/{id}', [RutinaController::class, 'getInfoRutina'])->name('rutinas.info');
Route::post('/rutinas/asignar', [RutinaController::class, 'asignar'])->name('rutinas.asignar');

Route::post('/rutinas/asignar-existente', [RutinaController::class, 'asignarExistente'])->name('rutinas.asignarExistente');

Route::get('/rutinas/listar', [RutinaController::class, 'getRutinas'])->name('rutinas.listar');

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
})->name('rutinas.show');

Route::controller(CitaController::class)->group(function () {

    Route::get('/cita', 'index')->name('cita.index');

    Route::get('/cita/crear', 'create')->name('cita.create');
    Route::post('/cita', 'store')->name('cita.store');

    Route::get('/cita/{id}/editar', 'edit')->name('cita.edit');
    Route::put('/cita/{id}', 'update')->name('cita.update');
    Route::post('/cita/{id}/cancelar', 'cancelar')->name('cita.cancelar');

    Route::delete('/cita/{id}', 'destroy')->name('cita.destroy');

    Route::get('/cita/{id}/detalles', 'show')->name('cita.show');

    Route::get('/cita/events', 'events')->name('cita.events');

    Route::get('/cita/disponibilidad', 'disponibilidad')->name('cita.disponibilidad');
});

Route::get('/progreso', [ProgresoController::class, 'index'])->name('progreso.index');
Route::get('/progreso/{id_usuario}', [ProgresoController::class, 'show'])->name('progreso.show');
Route::post('/progreso/guardar', [ProgresoController::class, 'store'])->name('progreso.store');
