@extends('layouts.plantilla')

@section('titulo', 'Editar Usuario')
@extends('layouts.app')

@section('title', 'Buscar Usuario - CEFIRET')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-search"></i> Buscar y Actualizar Usuarios
                    </h4>
                </div>
                
                <div class="card-body">
                    <!-- Formulario de búsqueda -->
                    <form method="POST" action="{{ route('usuarios.search') }}" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" 
                                   placeholder="Buscar por nombre, apellido, correo o teléfono..."
                                   value="{{ $query ?? '' }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                    
                    <!-- Resultados -->
                    @if(isset($usuarios))
                        @if($usuarios->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Completo</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->id_usuario }}</td>
                                            <td>{{ $usuario->nombre }} {{ $usuario->apaterno }} {{ $usuario->amaterno }}</td>
                                            <td>{{ $usuario->correo }}</td>
                                            <td>{{ $usuario->telefono }}</td>
                                            <td>
                                                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> No se encontraron usuarios
                            </div>
                        @endif
                    @endif
                    
                    <div class="mt-3">
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