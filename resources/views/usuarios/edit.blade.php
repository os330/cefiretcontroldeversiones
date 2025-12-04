@extends('layouts.app')

@section('title', 'Editar Usuario - CEFIRET')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Editar Usuario
                    </h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id_usuario) }}">
                        @csrf
                        @method('POST')
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" 
                                       value="{{ $usuario->nombre }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Apellido Paterno *</label>
                                <input type="text" name="apaterno" class="form-control" 
                                       value="{{ $usuario->apaterno }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Apellido Materno *</label>
                                <input type="text" name="amaterno" class="form-control" 
                                       value="{{ $usuario->amaterno }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Electrónico *</label>
                                <input type="email" name="correo" class="form-control" 
                                       value="{{ $usuario->correo }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono *</label>
                                <input type="text" name="telefono" class="form-control" 
                                       value="{{ $usuario->telefono }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" name="fecha_nac" class="form-control" 
                                   value="{{ $usuario->fecha_nac }}" required>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('usuarios.buscar') }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection