@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Detalles de la Cita</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $cita->id_cita }}</p>
            <p><strong>Paciente:</strong> {{ $cita->id_usuario }}</p>
            <p><strong>Fisioterapeuta:</strong> {{ $cita->id_fisioterapeuta }}</p>
            <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
            <p><strong>Hora:</strong> {{ $cita->hora }}</p>
            <p><strong>Motivo:</strong> {{ $cita->motivo }}</p>
        </div>
    </div>

    <a href="{{ route('cita.index') }}" class="btn btn-secondary mt-3">↩️ Volver</a>

</div>
@endsection
