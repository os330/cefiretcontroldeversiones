@extends('layouts.app')

@section('title', 'Progreso de Pacientes')

@section('content')
<div class="container">

    <h3 class="mb-4">Progreso de Pacientes</h3>

    <div class="card shadow">
        <div class="card-body">

            @if ($pacientes->isEmpty())
                <p>No hay pacientes registrados.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Ver Informe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pacientes as $p)
                            <tr>
                                <td>{{ $p->nombre }} {{ $p->apaterno }} {{ $p->amaterno }}</td>
                                <td>
                                    <a href="{{ route('progreso.show', $p->id_usuario) }}" 
                                       class="btn btn-primary btn-sm">
                                        Ver Progreso
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</div>
@endsection
