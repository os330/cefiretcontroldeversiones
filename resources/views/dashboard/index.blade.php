@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Pagina principal</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="text-primary">Bienvenido al sistema de CEFIRET</h1>
                        <h3 class="text-secondary">Hola, {{ session('user_nombre') }}</h3>
                        <p class="text-muted">Centro de Fisioterapia y Rehabilitacion</p>
                    </div>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Informacion del usuario</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nombre:</strong> {{ $usuario->nombre }} {{ $usuario->apaterno }} {{ $usuario->amaterno }}</p>
                                    <p><strong>Correo:</strong> {{ $usuario->correo }}</p>
                                    <p><strong>Tipo Usuario:</strong> 
                                        @if($usuario->id_tipo_usuario == 1)
                                            <span class="badge bg-primary">Administrador</span>
                                        @elseif($usuario->id_tipo_usuario == 2)
                                            <span class="badge bg-success">Fisioterapeuta</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Acciones Rapidas</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg">Registrar Nuevo Usuario</a>
                                        <a href="{{ route('usuarios.buscar') }}" class="btn btn-secondary btn-lg">Buscar Usuario
                                        <a href="{{ route('expedientes.buscar') }}" class="btn btn-success btn-lg">Consultar Expediente</a>
                                        <a href="{{ route('rutinas.index') }}" class="btn btn-warning btn-lg">Gestionar Rutinas</a>
                                        <a href="{{ route('cita.index') }}" class="btn btn-info btn-lg">Gestionar Citas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0">Informacion importante</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <img src="{{ asset('img/1.jpg') }}" 
                                                     alt="Fisioterapia" 
                                                     class="img-fluid rounded mb-2"
                                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                                                <p class="small">La lumbalgia crónica sería aquella que se prolonga en el tiempo más allá de 3 meses.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <p class="small">Los problemas lumbares están aumentando entre la población española adulta, y esto es causado en parte por un empeoramiento de nuestras prácticas posturales, tanto en el trabajo como durante el descanso, y por nuestro creciente sedentarismo, lo que disminuye nuestra flexibilidad general, además de debilitar nuestro sistema músculo-esquelético.</p>
                                                <img src="{{ asset('img/2.jpg') }}" 
                                                     alt="Rehabilitación" 
                                                     class="img-fluid rounded mt-2"
                                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <h6>Recomendaciones generales para evitar problemas lumbares:</h6>
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
                            <small>© 2025 CEFIRET. Todos los derechos reservados. Autores: Oscar Chavez Villada y Jetsibee Gutierrez Ramirez</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection