@extends('layouts.plantilla')

@section('titulo', 'Editar Rutina')

@section('contenido')

<h2>Editar Rutina</h2>

<form action="{{ route('rutinas.actualizar', $rutina->id_rutina) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Paciente:</label>
    <select name="id_usuario" required>
        @foreach($pacientes as $p)
            <option value="{{ $p->id_usuario }}"
                {{ $rutina->id_usuario == $p->id_usuario ? 'selected' : '' }}>
                {{ $p->nombre }} {{ $p->apaterno }}
            </option>
        @endforeach
    </select>

    <label>Nombre de la rutina:</label>
    <input type="text" name="nombre_rutina" value="{{ $rutina->nombre_rutina }}" required>

    <label>Instrucciones:</label>
    <textarea name="instrucciones">{{ $rutina->instrucciones }}</textarea>

    <label>Fecha inicio:</label>
    <input type="date" name="fecha_inicio" value="{{ $rutina->fecha_inicio }}" required>

    <label>Fecha fin:</label>
    <input type="date" name="fecha_fin" value="{{ $rutina->fecha_fin }}">

    <label>Estatus:</label>
    <select name="estatus">
        <option value="activa"   {{ $rutina->estatus == 'activa' ? 'selected' : '' }}>Activa</option>
        <option value="inactiva" {{ $rutina->estatus == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
    </select>

    <button class="btn" type="submit">Actualizar Rutina</button>
</form>

@endsection
