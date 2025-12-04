@extends('layouts.app')

@section('titulo', 'Crear Cita')

@section('contenido')

<h2>Registrar Nueva Cita</h2>

<form action="{{ route('citas.guardar') }}" method="POST">
    @csrf

    <label>Paciente:</label>
    <select name="id_usuario" required>
        <option value="">Seleccione...</option>
        @foreach($pacientes as $p)
            <option value="{{ $p->id_usuario }}">{{ $p->nombre }} {{ $p->apaterno }}</option>
        @endforeach
    </select>

    <label>Fisioterapeuta:</label>
    <select name="id_fisioterapeuta">
        <option value="">Seleccione...</option>
        @foreach($fisios as $f)
            <option value="{{ $f->id_usuario }}">{{ $f->nombre }} {{ $f->apaterno }}</option>
        @endforeach
    </select>

    <label>Fecha:</label>
    <input type="date" name="fecha" required>

    <label>Hora:</label>
    <input type="time" name="hora" required>

    <label>Motivo:</label>
    <textarea name="motivo"></textarea>

    <label>Observaciones:</label>
    <textarea name="observaciones"></textarea>

    <label>Estatus:</label>
    <select name="estatus">
        <option value="pendiente">Pendiente</option>
        <option value="confirmada">Confirmada</option>
        <option value="cancelada">Cancelada</option>
    </select>

    <button class="btn" type="submit">Guardar Cita</button>
</form>

@endsection
