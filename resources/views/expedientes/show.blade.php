@extends('layouts.app')

@section('title', 'Expediente Médico - CEFIRET')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-file-medical"></i> Expediente Médico
                    </h4>
                </div>
                
                <div class="card-body">
                    <!-- Información del paciente -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Datos del Paciente</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Nombre Completo:</th>
                                    <td>{{ $paciente->nombre }} {{ $paciente->apaterno }} {{ $paciente->amaterno }}</td>
                                </tr>
                                <tr>
                                    <th>Correo:</th>
                                    <td>{{ $paciente->correo }}</td>
                                </tr>
                                <tr>
                                    <th>Teléfono:</th>
                                    <td>{{ $paciente->telefono }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha Nacimiento:</th>
                                    <td>{{ date('d/m/Y', strtotime($paciente->fecha_nac)) }}</td>
                                </tr>
                                <tr>
                                    <th>Edad:</th>
                                    <td>
                                        @php
                                            $edad = date_diff(date_create($paciente->fecha_nac), date_create('today'))->y;
                                            echo $edad . ' años';
                                        @endphp
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Información Médica</h5>
                            <p class="text-muted">
                                <i class="bi bi-info-circle"></i> 
                                Aquí se mostraría la información médica del paciente, 
                                historial de consultas, diagnósticos, tratamientos, etc.
                            </p>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                Esta sección está en desarrollo. Próximamente se integrará 
                                el historial médico completo.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Secciones del expediente -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-clipboard-pulse fs-1 text-primary"></i>
                                    <h5>Historial Clínico</h5>
                                    <p class="text-muted">Consultas anteriores</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-prescription fs-1 text-success"></i>
                                    <h5>Tratamientos</h5>
                                    <p class="text-muted">Tratamientos activos</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-calendar-check fs-1 text-warning"></i>
                                    <h5>Citas</h5>
                                    <p class="text-muted">Próximas citas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('expedientes.buscar') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver a Búsqueda
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="bi bi-house-door"></i> Ir al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection