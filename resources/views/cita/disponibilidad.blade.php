@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Disponibilidad para el {{ $fecha }}</h2>

    <div class="card">
        <div class="card-body">
            <h5>Horas disponibles:</h5>

            @if(count($disponibles) == 0)
                <p class="text-danger">No hay horarios disponibles.</p>
            @else
                <ul>
                    @foreach($disponibles as $h)
                        <li>{{ $h }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <a href="{{ route('cita.index') }}" class="btn btn-secondary mt-3">↩️ Volver</a>

</div>
@endsection
