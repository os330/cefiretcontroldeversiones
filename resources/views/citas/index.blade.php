@extends('layouts.app')

@section('title', 'Gestión de Citas - CEFIRET')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-alt"></i> Gestión de Citas
                    </h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Lista de Citas Programadas</h5>
                            <p class="text-muted">
                                Gestiona las citas de fisioterapia para los pacientes.
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('citas.create') }}" class="btn btn-success me-2">
                                <i class="fas fa-plus"></i> Agendar Nueva Cita
                            </a>
                            <a href="{{ route('citas.disponibilidad') }}" class="btn btn-info">
                                <i class="fas fa-clock"></i> Ver Disponibilidad
                            </a>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body py-2">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <input type="date" id="filtroFecha" class="form-control" 
                                                   value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <select id="filtroEstatus" class="form-select">
                                                <option value="">Todos los estatus</option>
                                                <option value="pendiente">Pendiente</option>
                                                <option value="confirmada">Confirmada</option>
                                                <option value="completada">Completada</option>
                                                <option value="cancelada">Cancelada</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="filtroFisioterapeuta" class="form-select">
                                                <option value="">Todos los fisioterapeutas</option>
                                                @foreach($fisioterapeutas as $fisio)
                                                    <option value="{{ $fisio->id_usuario }}">
                                                        {{ $fisio->nombre }} {{ $fisio->apaterno }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary w-100" onclick="filtrarCitas()">
                                                <i class="fas fa-filter"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(count($citas) == 0)
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <h4>No hay citas programadas</h4>
                            <p class="text-muted">Comienza agendando tu primera cita</p>
                            <a href="{{ route('citas.create') }}" class="btn btn-success mt-3">
                                <i class="fas fa-plus"></i> Agendar Primera Cita
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="tablaCitas">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Fisioterapeuta</th>
                                        <th>Motivo</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas as $cita)
                                        @php
                                            $colorEstatus = [
                                                'pendiente' => 'warning',
                                                'confirmada' => 'success',
                                                'completada' => 'info',
                                                'cancelada' => 'danger'
                                            ][$cita->estatus] ?? 'secondary';
                                        @endphp
                                        <tr data-fisio="{{ $cita->id_fisioterapeuta }}" 
                                            data-estatus="{{ $cita->estatus }}"
                                            data-fecha="{{ $cita->fecha }}">
                                            <td><strong>#{{ $cita->id_cita }}</strong></td>
                                            <td>
                                                <i class="far fa-calendar me-1"></i>
                                                {{ date('d/m/Y', strtotime($cita->fecha)) }}
                                            </td>
                                            <td>
                                                <i class="far fa-clock me-1"></i>
                                                {{ date('H:i', strtotime($cita->hora)) }}
                                            </td>
                                            <td>
                                                <strong>{{ $cita->paciente_nombre ?? 'N/A' }} {{ $cita->paciente_apaterno ?? '' }}</strong>
                                            </td>
                                            <td>
                                                {{ $cita->fisio_nombre ?? 'N/A' }} {{ $cita->fisio_apaterno ?? '' }}
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($cita->motivo, 30) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $colorEstatus }}">
                                                    {{ ucfirst($cita->estatus) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('citas.edit', $cita->id_cita) }}" 
                                                       class="btn btn-outline-primary" title="Editar cita">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-info ms-1"
                                                            onclick="verDetallesCita({{ $cita->id_cita }})"
                                                            title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if($cita->estatus != 'cancelada')
                                                        <form action="{{ route('citas.cancelar', $cita->id_cita) }}" 
                                                              method="POST" class="d-inline ms-1"
                                                              onsubmit="return confirm('¿Cancelar esta cita?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-warning" title="Cancelar cita">
                                                                <i class="fas fa-times-circle"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('citas.destroy', $cita->id_cita) }}" 
                                                          method="POST" class="d-inline ms-1"
                                                          onsubmit="return confirm('¿Eliminar esta cita permanentemente?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Eliminar cita">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Pendientes</h6>
                                    <h3 class="text-warning">
                                        {{ collect($citas)->where('estatus', 'pendiente')->count() }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Confirmadas</h6>
                                    <h3 class="text-success">
                                        {{ collect($citas)->where('estatus', 'confirmada')->count() }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Completadas</h6>
                                    <h3 class="text-info">
                                        {{ collect($citas)->where('estatus', 'completada')->count() }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-danger">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Canceladas</h6>
                                    <h3 class="text-danger">
                                        {{ collect($citas)->where('estatus', 'cancelada')->count() }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>Regresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detallesCitaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalles de la Cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detallesCitaContent">
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    
    .card {
        margin-bottom: 20px;
    }
    
    .table th {
        background-color: #2c3e50;
        color: white;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('scripts')
<script>
    function filtrarCitas() {
        const fecha = document.getElementById('filtroFecha').value;
        const estatus = document.getElementById('filtroEstatus').value;
        const fisioterapeuta = document.getElementById('filtroFisioterapeuta').value;
        
        const filas = document.querySelectorAll('#tablaCitas tbody tr');
        
        filas.forEach(fila => {
            let mostrar = true;
            
            if (fecha) {
                const fechaCita = fila.getAttribute('data-fecha');
                if (fechaCita !== fecha) {
                    mostrar = false;
                }
            }
            
            if (estatus) {
                const estatusCita = fila.getAttribute('data-estatus');
                if (estatusCita !== estatus) {
                    mostrar = false;
                }
            }
            
            if (fisioterapeuta) {
                const fisioCita = fila.getAttribute('data-fisio');
                if (fisioCita !== fisioterapeuta) {
                    mostrar = false;
                }
            }
            
            fila.style.display = mostrar ? '' : 'none';
        });
    }
    
    function verDetallesCita(id) {
        fetch(`/citas/${id}/detalles`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('detallesCitaContent').innerHTML = html;
                const modal = new bootstrap.Modal(document.getElementById('detallesCitaModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('No se pudieron cargar los detalles de la cita');
            });
    }
    
    fetch('/citas/{id}/detalles')
        .then(response => response.text())
        .then(html => {
            document.getElementById('detallesCitaContent').innerHTML = html;
        });
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('filtroFecha').value = new Date().toISOString().split('T')[0];
    });
</script>
@endsection