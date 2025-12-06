@extends('layouts.app')

@section('title', 'Registrar Usuario - CEFIRET')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrar Nuevo Usuario</h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0"><i class="bi bi-exclamation-triangle"></i> {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf
                        
                        <h5 class="mb-3 text-primary">Datos Personales</h5>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required
                                       value="{{ old('nombre') }}">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Apellido Paterno *</label>
                                <input type="text" name="apaterno" class="form-control" required
                                       value="{{ old('apaterno') }}">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Apellido Materno *</label>
                                <input type="text" name="amaterno" class="form-control" required
                                       value="{{ old('amaterno') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Electrónico *</label>
                                <input type="email" name="correo" class="form-control" required
                                       value="{{ old('correo') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono *</label>
                                <input type="text" name="telefono" class="form-control" required
                                       value="{{ old('telefono') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Nacimiento *</label>
                                <input type="date" name="fecha_nac" class="form-control" required
                                       value="{{ old('fecha_nac') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contraseña *</label>
                                <input type="password" name="contrasena" class="form-control" required minlength="6">
                                <small class="text-muted">Mínimo 6 caracteres</small>
                            </div>
                        </div>
                        
                        <h5 class="mb-3 text-primary mt-4">Tipo de Usuario</h5>
                        
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-check card border p-3 h-100">
                                        <input class="form-check-input" type="radio" name="id_tipo_usuario" 
                                               id="tipo_admin" value="1" {{ old('id_tipo_usuario') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_admin">
                                            <i class="bi bi-shield-check fs-4 text-primary"></i>
                                            <h6 class="mt-2">Administrador</h6>
                                            <small class="text-muted">Acceso completo al sistema</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="form-check card border p-3 h-100">
                                        <input class="form-check-input" type="radio" name="id_tipo_usuario" 
                                               id="tipo_fisio" value="2" {{ old('id_tipo_usuario') == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_fisio">
                                            <i class="bi bi-heart-pulse fs-4 text-success"></i>
                                            <h6 class="mt-2">Fisioterapeuta</h6>
                                            <small class="text-muted">Mismos privilegios que el Administrador</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="form-check card border p-3 h-100">
                                        <input class="form-check-input" type="radio" name="id_tipo_usuario" 
                                               id="tipo_paciente" value="3" {{ old('id_tipo_usuario') == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_paciente">
                                            <i class="bi bi-person-badge fs-4 text-info"></i>
                                            <h6 class="mt-2">Paciente</h6>
                                            <small class="text-muted">Persona que recibirá el tratamiento</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            @error('id_tipo_usuario')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="alert alert-info">
                            <strong>Nota:</strong> Para completar el registro del paciente le pedirá completar 
                            el expediente médico después de este registro.
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-md-2">Regresar</a>
                            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection