@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Editar Cita</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('cita.update', $cita->id_cita) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Paciente:</label>
            <select name="paciente_id" class="form-control" required>
                @foreach($pacientes as $p)
                    <option value="{{ $p->id_usuario }}" {{ $p->id_usuario == $cita->id_usuario ? 'selected' : '' }}>
                        {{ $p->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fisioterapeuta:</label>
            <select name="fisioterapeuta_id" class="form-control" required>
                @foreach($fisios as $f)
                    <option value="{{ $f->id_usuario }}" {{ $f->id_usuario == $cita->id_fisioterapeuta ? 'selected' : '' }}>
                        {{ $f->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha:</label>
            <input type="date" name="fecha" value="{{ $cita->fecha }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Hora:</label>
            <input type="time" name="hora" value="{{ $cita->hora }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Motivo:</label>
            <textarea name="motivo" class="form-control">{{ $cita->motivo }}</textarea>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('cita.index') }}" class="btn btn-secondary">Volver</a>

    </form>

</div>
@endsection
