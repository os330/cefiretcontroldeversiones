@extends('layouts.app')

@section('title', 'Consultar Expediente - CEFIRET')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Consultar Expediente Médico</h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('expedientes.search') }}" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" 
                                   placeholder="Buscar paciente por nombre, apellido, correo o teléfono..."
                                   value="{{ $query ?? '' }}">
                            <button class="btn btn-success" type="submit">Buscar Paciente</button>
                        </div>
                    </form>
                    
                    @if(isset($pacientes))
                        @if($pacientes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Completo</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Fecha Nacimiento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pacientes as $paciente)
                                        <tr>
                                            <td>{{ $paciente->id_usuario }}</td>
                                            <td>{{ $paciente->nombre }} {{ $paciente->apaterno }} {{ $paciente->amaterno }}</td>
                                            <td>{{ $paciente->correo }}</td>
                                            <td>{{ $paciente->telefono }}</td>
                                            <td>{{ date('d/m/Y', strtotime($paciente->fecha_nac)) }}</td>
                                            <td>
                                                <a href="{{ route('expedientes.show', $paciente->id_usuario) }}" 
                                                   class="btn btn-info btn-sm">Ver Expediente</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">No se encontraron pacientes</div>
                        @endif
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection