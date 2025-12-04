@extends('layouts.plantilla')

@section('titulo', 'Agregar Detalle')

@section('contenido')

<h2>Agregar Detalle de Rutina</h2>

<form action="{{ route('rutinadetalles.guardar') }}" method="POST">
    @csrf

    <label>Rutina:</label>
    <select name="id_rutina" required>
        <option value="">Seleccione...</option>
        @foreach($rutinas as $r)
            <option value="{{ $r->id_rutina }}">{{ $r->nombre_rutina }}</option>
        @endforeach
    </select>

    <label>Ejercicio:</label>
    <select name="id_ejercicio" required>
        <option value="">Seleccione...</option>
        @foreach($ejercicios as $e)
            <option value="{{ $e->id_ejercicio }}">{{ $e->nombre_ejercicio }}</option>
        @endforeach
    </select>

    <label>Repeticiones:</label>
    <input type="number" name="repeticiones" value="{{ old('repeticiones') }}">

    <label>Series:</label>
    <input type="number" name="series" value="{{ old('series') }}">

    <label>Tiempo (segundos):</label>
    <input type="number" name="tiempo" value="{{ old('tiempo') }}">

    <label>Orden en la rutina:</label>
    <input type="number" name="orden" value="{{ old('orden') }}">

    <button class="btn" type="submit">Guardar Detalle</button>
</form>

@endsection
