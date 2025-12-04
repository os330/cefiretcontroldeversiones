@extends('layouts.app')

@section('title', 'Crear Rutina - CEFIRET')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Crear Nueva Rutina
                    </h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('rutinas.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Rutina *</label>
                            <input type="text" name="nombre" class="form-control" 
                                   placeholder="Ej: Rutina para lumbalgia crónica" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descripción *</label>
                            <textarea name="descripcion" class="form-control" rows="4" 
                                      placeholder="Describa los ejercicios, objetivos y precauciones..." required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duración (minutos) *</label>
                                <input type="number" name="duracion" class="form-control" min="1" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Frecuencia *</label>
                                <select name="frecuencia" class="form-select" required>
                                    <option value="">Seleccionar frecuencia</option>
                                    <option value="Diaria">Diaria</option>
                                    <option value="3 veces por semana">3 veces por semana</option>
                                    <option value="Alternando días">Alternando días</option>
                                    <option value="Semanal">Semanal</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Paciente asignado</label>
                            <select class="form-select">
                                <option value="">Seleccionar paciente (opcional)</option>
                                <!-- Aquí irían los pacientes de la base de datos -->
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('rutinas.index') }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Rutina
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection