@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Agendar Nueva Cita</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('cita.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Paciente:</label>
            <select name="paciente_id" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($pacientes as $p)
                    <option value="{{ $p->id_usuario }}">{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fisioterapeuta:</label>
            <select name="fisioterapeuta_id" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($fisios as $f)
                    <option value="{{ $f->id_usuario }}">{{ $f->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Hora:</label>
            <input type="time" name="hora" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Motivo:</label>
            <textarea name="motivo" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Guardar Cita</button>
        <a href="{{ route('cita.index') }}" class="btn btn-secondary">Volver</a>
    </form>

</div>
@endsection
