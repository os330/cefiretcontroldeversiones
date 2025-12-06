@section('titulo', 'Editar Usuario')
@extends('layouts.app')

@section('title', 'Buscar Usuario - CEFIRET')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Buscar y actualizar usuarios</h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.search') }}" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" 
                                   placeholder="Buscar por nombre, apellido, correo o teléfono..."
                                   value="{{ $query ?? '' }}">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </form>

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
                                                   class="btn btn-warning btn-sm">Editar</a>
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
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection