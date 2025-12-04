<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\RutinaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// RUTA PRINCIPAL - Redirige según sesión
Route::get('/', function () {
    if (session()->has('user_id')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login.form');
});

// RUTAS DE LOGIN (públicas)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// RUTAS PROTEGIDAS (verifican sesión en controladores)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// USUARIOS (PACIENTES) - Usando UsuarioController
// ============================================================
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

// ============================================================
// EXPEDIENTES - Usando ExpedienteController
// ============================================================
Route::controller(ExpedienteController::class)->group(function () {
    // Buscar expedientes
    Route::get('/expedientes/buscar', 'buscar')->name('expedientes.buscar');
    Route::post('/expedientes/buscar', 'search')->name('expedientes.search');
    
    // Ver expediente
    Route::get('/expedientes/ver/{id}', 'show')->name('expedientes.show');
});

// ============================================================
// RUTINAS - Usando RutinaController
// ============================================================
Route::controller(RutinaController::class)->group(function () {
    // Listar rutinas
    Route::get('/rutinas', 'index')->name('rutinas.index');
    
    // Crear rutina
    Route::get('/rutinas/crear', 'create')->name('rutinas.create');
    Route::post('/rutinas/crear', 'store')->name('rutinas.store');
});
