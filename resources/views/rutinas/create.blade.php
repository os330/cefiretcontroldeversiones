@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 text-primary">Crear Nueva Rutina</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('rutinas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Paciente</label>
            <select name="id_paciente" class="form-select" required>
                <option value="">Selecciona un paciente...</option>
                @foreach($pacientes as $p)
                    <option value="{{ $p->id_usuario }}">
                        {{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Fecha de asignación</label>
            <input type="date" name="fecha_asignacion" class="form-control" required>
        </div>

        <hr>

        <h5 class="text-secondary mt-3">Información del Video</h5>

        <div class="mb-3">
            <label class="form-label fw-bold">Título del video</label>
            <input type="text" name="video_titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">URL del video</label>
            <input type="text" name="video_url" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Descripción (opcional)</label>
            <textarea name="video_descripcion" class="form-control" rows="2"></textarea>
        </div>

        <hr>

        <h5 class="text-secondary">Detalles del ejercicio</h5>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Repeticiones</label>
                <input type="number" name="repeticiones" class="form-control" min="1">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Series</label>
                <input type="number" name="series" class="form-control" min="1">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Tiempo estimado (minutos)</label>
                <input type="number" name="tiempo" class="form-control" min="1">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>

        <hr>

        <h5 class="text-secondary">Días asignados</h5>
        <p class="text-muted">Selecciona al menos un día</p>

        <div class="mb-3">
            @php
                $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
            @endphp

            @foreach($dias as $dia)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox"
                           name="dias[]" value="{{ $dia }}" id="dia_{{ $dia }}">
                    <label class="form-check-label" for="dia_{{ $dia }}">{{ $dia }}</label>
                </div>
            @endforeach
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <a href="{{ route('rutinas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Rutina</button>
        </div>

    </form>

</div>
@endsection
