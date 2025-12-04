@extends('layouts.app')

@section('title', 'Rutinas - CEFIRET')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-check"></i> Gestión de Rutinas
                    </h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Información de rutinas -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5>Rutinas de Ejercicio y Tratamiento</h5>
                            <p class="text-muted">
                                En esta sección puedes gestionar las rutinas de ejercicio 
                                y tratamiento para los pacientes del centro.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('rutinas.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Crear Nueva Rutina
                            </a>
                        </div>
                    </div>
                    
                    <!-- Ejemplo de rutinas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Rutina para Lumbalgia</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Duración:</strong> 30 minutos</p>
                                    <p><strong>Frecuencia:</strong> 3 veces por semana</p>
                                    <p><strong>Ejercicios:</strong> Estiramientos lumbares, fortalecimiento abdominal</p>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-primary">Ver Detalles</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Rutina Post-operatoria Rodilla</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Duración:</strong> 45 minutos</p>
                                    <p><strong>Frecuencia:</strong> Diaria</p>
                                    <p><strong>Ejercicios:</strong> Movilidad articular, fortalecimiento cuadriceps</p>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-primary">Ver Detalles</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="alert alert-info mt-4">
                        <h6><i class="bi bi-lightbulb"></i> Recomendaciones para rutinas:</h6>
                        <ul class="mb-0">
                            <li>Personalizar según la condición del paciente</li>
                            <li>Considerar limitaciones físicas</li>
                            <li>Incluir progresiones graduales</li>
                            <li>Revisar periódicamente el progreso</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection