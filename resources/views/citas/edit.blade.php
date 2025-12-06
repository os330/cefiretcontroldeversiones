@extends('layouts.app')

@section('title', 'Editar Cita - CEFIRET')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Editar Cita
                    </h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('citas.update', $cita->id_cita) }}" id="editarCitaForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Seleccionar Paciente *
                                </label>
                                <select name="id_usuario" class="form-select" required>
                                    <option value="">Seleccionar paciente...</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id_usuario }}" 
                                                {{ $cita->id_usuario == $paciente->id_usuario ? 'selected' : '' }}>
                                            {{ $paciente->nombre }} {{ $paciente->apaterno }} {{ $paciente->amaterno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user-md"></i> Seleccionar Fisioterapeuta *
                                </label>
                                <select name="id_fisioterapeuta" id="id_fisioterapeuta" class="form-select" required>
                                    <option value="">Seleccionar fisioterapeuta...</option>
                                    @foreach($fisioterapeutas as $fisio)
                                        <option value="{{ $fisio->id_usuario }}"
                                                {{ $cita->id_fisioterapeuta == $fisio->id_usuario ? 'selected' : '' }}>
                                            {{ $fisio->nombre }} {{ $fisio->apaterno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="far fa-calendar"></i> Fecha de la Cita *
                                </label>
                                <input type="date" 
                                       name="fecha" 
                                       id="fecha_cita" 
                                       class="form-control" 
                                       value="{{ $cita->fecha }}" 
                                       required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="far fa-clock"></i> Hora de la Cita *
                                </label>
                                <input type="time" 
                                       name="hora" 
                                       class="form-control" 
                                       value="{{ $cita->hora }}" 
                                       required>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-stethoscope"></i> Motivo de la Cita *
                                </label>
                                <textarea name="motivo" 
                                          class="form-control" 
                                          rows="3" 
                                          required>{{ $cita->motivo }}</textarea>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-clipboard"></i> Observaciones (opcional)
                                </label>
                                <textarea name="observaciones" 
                                          class="form-control" 
                                          rows="2">{{ $cita->observaciones }}</textarea>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-info-circle"></i> Estatus de la Cita *
                                </label>
                                <select name="estatus" class="form-select" required>
                                    <option value="pendiente" {{ $cita->estatus == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmada" {{ $cita->estatus == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                    <option value="completada" {{ $cita->estatus == 'completada' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelada" {{ $cita->estatus == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('citas.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Actualizar Cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection