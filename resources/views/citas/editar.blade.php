@extends('layouts.plantilla')

@section('titulo', 'Editar Cita')

@section('contenido')

<h2>Editar Cita</h2>

<form action="{{ route('citas.actualizar', $cita->id_cita) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Paciente:</label>
    <select name="id_usuario" required>
        @foreach($pacientes as $p)
            <option value="{{ $p->id_usuario }}"
                {{ $cita->id_usuario == $p->id_usuario ? 'selected' : '' }}>
                {{ $p->nombre }} {{ $p->apaterno }}
            </option>
        @endforeach
    </select>

    <label>Fisioterapeuta:</label>
    <select name="id_fisioterapeuta">
        @foreach($fisios as $f)
            <option value="{{ $f->id_usuario }}"
                {{ $cita->id_fisioterapeuta == $f->id_usuario ? 'selected' : '' }}>
                {{ $f->nombre }} {{ $f->apaterno }}
            </option>
        @endforeach
    </select>

    <label>Fecha:</label>
    <input type="date" name="fecha" value="{{ $cita->fecha }}" required>

    <label>Hora:</label>
    <input type="time" name="hora" value="{{ $cita->hora }}" required>

    <label>Motivo:</label>
    <textarea name="motivo">{{ $cita->motivo }}</textarea>

    <label>Observaciones:</label>
    <textarea name="observaciones">{{ $cita->observaciones }}</textarea>

    <label>Estatus:</label>
    <select name="estatus">
        <option value="pendiente"  {{ $cita->estatus == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="confirmada" {{ $cita->estatus == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
        <option value="cancelada"  {{ $cita->estatus == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
    </select>

    <button class="btn" type="submit">Actualizar Cita</button>
</form>

@endsection
