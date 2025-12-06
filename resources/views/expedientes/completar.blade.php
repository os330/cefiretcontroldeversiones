@extends('layouts.app')

@section('title', 'Expediente Clínico - CEFIRET')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Expediente clinico</h4>
                    <p class="mb-0 mt-2">
                        <strong>Paciente:</strong> {{ $paciente->nombre }} {{ $paciente->apaterno }} {{ $paciente->amaterno }}
                    </p>
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
                    
                    <form method="POST" action="{{ route('expedientes.guardar', $paciente->id_usuario) }}">
                        @csrf
                        
                        <input type="hidden" name="id_usuario" value="{{ $paciente->id_usuario }}">
                        
                        <div class="section-header bg-info text-white p-3 mb-4 rounded">
                            <h5 class="mb-0">
                                <i class="bi bi-person-lines-fill"></i> Datos Generales
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Creación *</label>
                                <input type="date" name="fecha_creacion" class="form-control" required 
                                       value="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sexo *</label>
                                <select name="sexo" class="form-select" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Edad *</label>
                                <input type="number" name="edad" class="form-control" required 
                                       placeholder="Ej: 25">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Estado Civil *</label>
                                <select name="edo_civil" class="form-select" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Unión libre">Unión libre</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ocupación *</label>
                                <input type="text" name="ocupacion" class="form-control" required 
                                       placeholder="Ej: Estudiante, Empleado, etc.">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Domicilio *</label>
                                <input type="text" name="domicilio" class="form-control" required 
                                       placeholder="Calle y número">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Colonia *</label>
                                <input type="text" name="colonia" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Municipio *</label>
                                <input type="text" name="municipio" class="form-control" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lugar de Nacimiento *</label>
                                <input type="text" name="lugar_nac" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lugar de Residencia *</label>
                                <input type="text" name="lugar_residencia" class="form-control" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contacto de Emergencia *</label>
                                <input type="text" name="contacto_emergencia" class="form-control" required 
                                       placeholder="Nombre y teléfono">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nacionalidad *</label>
                                <input type="text" name="nacionalidad" class="form-control" required 
                                       value="Mexicana">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Religión</label>
                                <input type="text" name="religion" class="form-control" 
                                       placeholder="Ej: Católica">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Escolaridad</label>
                                <select name="escolaridad" class="form-select">
                                    <option value="">Seleccionar</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="Preparatoria">Preparatoria</option>
                                    <option value="Universidad">Universidad</option>
                                    <option value="Posgrado">Posgrado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="section-header bg-success text-white p-3 mb-4 rounded mt-4">
                            <h5 class="mb-0">
                                <i class="bi bi-heart-pulse"></i> Signos Vitales
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Presión Arterial</label>
                                <input type="text" name="presion_arterial" class="form-control" 
                                       placeholder="Ej: 120/80">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Frecuencia Cardíaca</label>
                                <input type="text" name="frec_cardiaca" class="form-control" 
                                       placeholder="Ej: 72 lpm">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Llenado Capilar</label>
                                <input type="text" name="llenado_capilar" class="form-control" 
                                       placeholder="Ej: < 2 seg">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Glucosa</label>
                                <input type="text" name="glucosa" class="form-control" 
                                       placeholder="Ej: 95 mg/dL">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Frecuencia Respiratoria</label>
                                <input type="text" name="frec_respiratoria" class="form-control" 
                                       placeholder="Ej: 16 rpm">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alimentación</label>
                                <input type="text" name="alimentacion" class="form-control" 
                                       placeholder="Ej: Balanceada, vegetariana, etc.">
                            </div>
                        </div>
                        
                        <div class="section-header bg-warning text-white p-3 mb-4 rounded mt-4">
                            <h5 class="mb-0">
                                <i class="bi bi-droplet"></i> Hábitos Higiénicos
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Baño</label>
                                <input type="text" name="bano" class="form-control" 
                                       placeholder="Frecuencia del baño">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Lavado de Manos</label>
                                <input type="text" name="lavado_manos" class="form-control" 
                                       placeholder="Frecuencia">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Lavado de Dientes</label>
                                <input type="text" name="lavado_dientes" class="form-control" 
                                       placeholder="Frecuencia">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Cambio de Ropa</label>
                                <input type="text" name="cambio_ropa" class="form-control" 
                                       placeholder="Frecuencia">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Revisión de Pies</label>
                                <input type="text" name="revision_pies" class="form-control" 
                                       placeholder="Frecuencia">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Horas de Sueño</label>
                                <input type="text" name="horas_sueno" class="form-control" 
                                       placeholder="Ej: 8 horas">
                            </div>
                        </div>
                        
                        <div class="section-header bg-secondary text-white p-3 mb-4 rounded mt-4">
                            <h5 class="mb-0">
                                <i class="bi bi-house-door"></i> Vivienda
                            </h5>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Detalles de Vivienda</label>
                            <input type="text" name="vivienda_detalles" class="form-control" 
                                   placeholder="Descripción general">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Techo</label>
                                <input type="text" name="techo" class="form-control" 
                                       placeholder="Material del techo">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Paredes</label>
                                <input type="text" name="paredes" class="form-control" 
                                       placeholder="Material de paredes">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Suelo</label>
                                <input type="text" name="suelo" class="form-control" 
                                       placeholder="Material del suelo">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Agua</label>
                                <input type="text" name="agua" class="form-control" 
                                       placeholder="Disponibilidad">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Luz</label>
                                <input type="text" name="luz" class="form-control" 
                                       placeholder="Servicio eléctrico">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Drenaje</label>
                                <input type="text" name="drenaje" class="form-control" 
                                       placeholder="Sistema de drenaje">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gas</label>
                                <input type="text" name="gas" class="form-control" 
                                       placeholder="Tipo de gas">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Limpieza del Hogar</label>
                                <input type="text" name="limpieza_hogar" class="form-control" 
                                       placeholder="Frecuencia">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <a href="{{ route('usuarios.create') }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Guardar Expediente Completo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .section-header {
        border-left: 5px solid;
    }
    .bg-info {
        border-left-color: #0dcaf0;
    }
    .bg-success {
        border-left-color: #198754;
    }
    .bg-warning {
        border-left-color: #ffc107;
    }
    .bg-secondary {
        border-left-color: #6c757d;
    }
</style>
@endsection