@extends('layouts.app')

@section('title', 'Progreso del Paciente')

@section('content')
<div class="container">

    <h3 class="mb-3">
        Progreso de {{ $paciente->nombre }} {{ $paciente->apaterno }}
    </h3>

    @if(!$rutina)
        <div class="alert alert-info">
            Este paciente aún no tiene una rutina asignada.
        </div>
        @return
    @endif

    @if(!$progreso)
        <div class="alert alert-warning">
            Aún no hay registros de progreso.  
            <br>El paciente podrá generar datos desde la app móvil.
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">

            <h5>Información de la Rutina</h5>
            <p><strong>Asignada:</strong> {{ $rutina->fecha_asignacion }}</p>
            <p><strong>Días:</strong> {{ implode(', ', json_decode($rutina->dias)) }}</p>

            <hr>

            <h5>Estado Actual</h5>
            <p>
                <strong>Progreso:</strong> 
                @if($progreso)
                    {{ $progreso->porcentaje }}%
                @else
                    0%
                @endif
            </p>

            <p>
                <strong>Observaciones:</strong><br>
                @if($progreso)
                    {{ $progreso->observaciones }}
                @else
                    Ninguna observación registrada.
                @endif
            </p>

        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Registrar Observaciones / Progreso
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('progreso.store') }}">
                @csrf

                <input type="hidden" name="id_paciente" value="{{ $paciente->id_usuario }}">

                <div class="mb-3">
                    <label class="form-label">Porcentaje de avance *</label>
                    <input type="number" name="porcentaje" min="0" max="100"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    Guardar Progreso
                </button>
            </form>

        </div>
    </div>

</div>
@endsection
    