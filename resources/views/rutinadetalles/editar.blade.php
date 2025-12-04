@extends('layouts.plantilla')

@section('titulo', 'Editar Detalle')

@section('contenido')

<h2>Editar Detalle de Rutina</h2>

<form action="{{ route('rutinadetalles.actualizar', $detalle->id_detalle) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Rutina:</label>
    <select name="id_rutina" required>
        @foreach($rutinas as $r)
            <option value="{{ $r->id_rutina }}"
                {{ $detalle->id_rutina == $r->id_rutina ? 'selected' : '' }}>
                {{ $r->nombre_rutina }}
            </option>
        @endforeach
    </select>

    <label>Ejercicio:</label>
    <select name="id_ejercicio" required>
        @foreach($ejercicios as $e)
            <option value="{{ $e->id_ejercicio }}"
                {{ $detalle->id_ejercicio == $e->id_ejercicio ? 'selected' : '' }}>
                {{ $e->nombre_ejercicio }}
            </option>
        @endforeach
    </select>

    <label>Repeticiones:</label>
    <input type="number" name="repeticiones" value="{{ $detalle->repeticiones }}">

    <label>Series:</label>
    <input type="number" name="series" value="{{ $detalle->series }}">

    <label>Tiempo (segundos):</label>
    <input type="number" name="tiempo" value="{{ $detalle->tiempo }}">

    <label>Orden en la rutina:</label>
    <input type="number" name="orden" value="{{ $detalle->orden }}">

    <button class="btn" type="submit">Actualizar Detalle</button>
</form>

@endsection
