@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-house-door"></i> Dashboard - CEFIRET
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="text-primary">¡Bienvenido al Sistema!</h1>
                        <h3 class="text-secondary">Hola, {{ session('user_nombre') }}</h3>
                        <p class="text-muted">Centro de Fisioterapia y Rehabilitación</p>
                    </div>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-person-circle"></i> Información del Usuario
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nombre:</strong> {{ $usuario->nombre }} {{ $usuario->apaterno }} {{ $usuario->amaterno }}</p>
                                    <p><strong>Correo:</strong> {{ $usuario->correo }}</p>
                                    <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No registrado' }}</p>
                                    @if($usuario->fecha_nac)
                                        <p><strong>Fecha Nacimiento:</strong> {{ date('d/m/Y', strtotime($usuario->fecha_nac)) }}</p>
                                    @endif
                                    <p><strong>Tipo Usuario:</strong> 
                                        @if($usuario->id_tipo_usuario == 1)
                                            <span class="badge bg-primary">Administrador</span>
                                        @elseif($usuario->id_tipo_usuario == 2)
                                            <span class="badge bg-success">Fisioterapeuta</span>
                                        @else
                                            <span class="badge bg-secondary">Usuario</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-lightning-charge"></i> Acciones Rápidas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg">
                                            <i class="bi bi-person-plus"></i> Registrar Nuevo Usuario
                                        </a>
                                        <a href="{{ route('usuarios.buscar') }}" class="btn btn-secondary btn-lg">
                                            <i class="bi bi-search"></i> Buscar Usuario
                                        </a>
                                        <a href="{{ route('expedientes.buscar') }}" class="btn btn-success btn-lg">
                                            <i class="bi bi-folder"></i> Consultar Expediente
                                        </a>
                                        <a href="{{ route('rutinas.index') }}" class="btn btn-warning btn-lg">
                                            <i class="bi bi-calendar-check"></i> Gestionar Rutinas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-info-circle"></i> Información Importante
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <img src="{{ asset('img/1.jpg') }}" 
                                                     alt="Fisioterapia" 
                                                     class="img-fluid rounded mb-2"
                                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                                                <h6 class="fw-bold">Lumbalgia Crónica</h6>
                                                <p class="small">Se considera crónica cuando se prolonga más allá de 3 meses.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Prevención de Problemas Lumbares</h6>
                                                <p class="small">Los problemas lumbares están aumentando debido a malas posturas y sedentarismo.</p>
                                                <img src="{{ asset('img/2.jpg') }}" 
                                                     alt="Rehabilitación" 
                                                     class="img-fluid rounded mt-2"
                                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <h6><i class="bi bi-exclamation-triangle"></i> Recomendaciones:</h6>
                                        <ul class="mb-0">
                                            <li>Mantener una postura correcta durante el trabajo</li>
                                            <li>Realizar ejercicios de estiramiento regularmente</li>
                                            <li>Consultar al fisioterapeuta ante el primer signo de dolor</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            <small>
                                Sistema CEFIRET - Versión 1.0<br>
                                © {{ date('Y') }} Centro de Fisioterapia y Rehabilitación
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection