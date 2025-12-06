@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 text-primary">Editar Rutina</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('rutinas.update', $rutina->id_rutina) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Paciente</label>
            <input type="text" class="form-control" disabled
                   value="{{ $rutina->nombre }} {{ $rutina->apaterno }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Fecha de asignación</label>
            <input type="date" name="fecha_asignacion"
                   class="form-control"
                   value="{{ $rutina->fecha_asignacion }}" disabled>
        </div>

        <hr>

        <h5 class="text-secondary mt-3">Información del Video</h5>

        <div class="mb-3">
            <label class="form-label fw-bold">Título del video</label>
            <input type="text" name="video_titulo" class="form-control"
                   value="{{ $rutina->titulo }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">URL del video</label>
            <input type="text" name="video_url" class="form-control"
                   value="{{ $rutina->url }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Descripción</label>
            <textarea name="video_descripcion" class="form-control" rows="2">{{ $rutina->descripcion }}</textarea>
        </div>

        <hr>
        <h5 class="text-secondary">Detalles del ejercicio</h5>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Repeticiones</label>
                <input type="number" name="repeticiones" class="form-control" min="1"
                       value="{{ $rutina->repeticiones }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Series</label>
                <input type="number" name="series" class="form-control" min="1"
                       value="{{ $rutina->series }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Tiempo estimado (minutos)</label>
                <input type="number" name="tiempo" class="form-control" min="1"
                       value="{{ $rutina->tiempo }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3">{{ $rutina->observaciones }}</textarea>
        </div>

        <hr>

        <h5 class="text-secondary">Días asignados</h5>
        <p class="text-muted">Selecciona al menos un día</p>

        <div class="mb-3">
            @php
                $diasSemana = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
            @endphp

            @foreach ($diasSemana as $dia)
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                           type="checkbox"
                           name="dias[]"
                           id="dia_{{ $dia }}"
                           value="{{ $dia }}"
                           {{ in_array($dia, $diasRutina) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dia_{{ $dia }}">
                        {{ $dia }}
                    </label>
                </div>
            @endforeach
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <a href="{{ route('rutinas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Rutina</button>
        </div>

    </form>

</div>
@endsection
