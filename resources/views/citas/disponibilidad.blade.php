@extends('layouts.app')

@section('title', 'Disponibilidad de Fisioterapeutas - CEFIRET')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-clock"></i> Disponibilidad de Fisioterapeutas
                    </h4>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Seleccionar Fisioterapeuta</label>
                            <select id="selectFisioterapeuta" class="form-select">
                                <option value="">Todos los fisioterapeutas</option>
                                @foreach($fisioterapeutas as $fisio)
                                    <option value="{{ $fisio->id_usuario }}">
                                        {{ $fisio->nombre }} {{ $fisio->apaterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Seleccionar Fecha</label>
                            <input type="date" id="fechaDisponibilidad" class="form-control" 
                                   value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100" onclick="cargarDisponibilidad()">
                                <i class="fas fa-search"></i> Ver Disponibilidad
                            </button>
                        </div>
                    </div>
                    
                    <div id="resultadosDisponibilidad">
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                            <h5>Selecciona un fisioterapeuta y fecha para ver la disponibilidad</h5>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('citas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Regresar a Citas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function cargarDisponibilidad() {
        const fisioterapeutaId = document.getElementById('selectFisioterapeuta').value;
        const fecha = document.getElementById('fechaDisponibilidad').value;
        
        if (!fecha) {
            alert('Por favor selecciona una fecha');
            return;
        }
        
        const resultadosDiv = document.getElementById('resultadosDisponibilidad');
        resultadosDiv.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Cargando disponibilidad...</p></div>';
        
        let url = `/citas/disponibilidad-por-fecha?fecha=${fecha}`;
        if (fisioterapeutaId) {
            url += `&fisioterapeuta=${fisioterapeutaId}`;
        }
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.citas.length === 0) {
                        resultadosDiv.innerHTML = `
                            <div class="alert alert-success">
                                <h5><i class="fas fa-check-circle"></i> Disponibilidad completa</h5>
                                <p>No hay citas programadas para esta fecha${fisioterapeutaId ? ' para este fisioterapeuta' : ''}.</p>
                                <p>Todos los horarios están disponibles.</p>
                            </div>
                        `;
                    } else {
                        let html = `<h5>Citas Programadas para ${new Date(fecha).toLocaleDateString('es-ES')}</h5>`;
                        html += `<div class="table-responsive mt-3"><table class="table table-hover"><thead><tr>
                                    <th>Hora</th><th>Paciente</th><th>Fisioterapeuta</th><th>Estatus</th>
                                </tr></thead><tbody>`;
                        
                        data.citas.forEach(cita => {
                            const estatusColor = {
                                'pendiente': 'warning',
                                'confirmada': 'success',
                                'completada': 'info',
                                'cancelada': 'danger'
                            }[cita.estatus] || 'secondary';
                            
                            html += `<tr>
                                <td><i class="far fa-clock"></i> ${cita.hora}</td>
                                <td>${cita.paciente_nombre || 'N/A'} ${cita.paciente_apaterno || ''}</td>
                                <td>${cita.fisio_nombre || 'N/A'}</td>
                                <td><span class="badge bg-${estatusColor}">${cita.estatus}</span></td>
                            </tr>`;
                        });
                        
                        html += `</tbody></table></div>`;
                        resultadosDiv.innerHTML = html;
                    }
                } else {
                    resultadosDiv.innerHTML = `<div class="alert alert-danger">Error: ${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultadosDiv.innerHTML = `<div class="alert alert-danger">Error al cargar la disponibilidad</div>`;
            });
    }
    
    document.getElementById('fechaDisponibilidad').addEventListener('change', cargarDisponibilidad);
</script>
@endsection