<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/principal', function () {
    return view('cliente.principal');
});

Route::get('/buscarE', function () {
    return view('cliente.buscarE');
});

Route::get('/actualizarD', function () {
    return view('cliente.actualizarD');
});

Route::get('/buscarU', function () {
    return view('cliente.buscarU');
});

Route::get('/rutinas', function () {
    return view('cliente.rutinas');
});

Route::get('/usuarios', function () {
    return view('cliente.usuarios');
});

Route::get('/index', function () {
    return view('views.index');
});