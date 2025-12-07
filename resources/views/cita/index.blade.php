@extends('layouts.app')

@section('content')
<style>
    .calendar-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .activities-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .activity-item {
        border-left: 4px solid #0d6efd;
        padding: 15px;
        margin-bottom: 12px;
        background: #f8f9fa;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: #e7f1ff;
        transform: translateX(5px);
    }

    .activity-item.cancelada {
        border-left-color: #dc3545;
        opacity: 0.7;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 10px;
    }

    .activity-title {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .activity-meta {
        font-size: 13px;
        color: #6c757d;
        margin: 3px 0;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-programada {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-cancelada {
        background: #f8d7da;
        color: #721c24;
    }

    .status-completada {
        background: #d4edda;
        color: #155724;
    }

    .btn-action-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-action-group .btn {
        padding: 6px 12px;
        font-size: 12px;
    }

    .add-cita-btn {
        padding: 12px 30px !important;
        font-size: 16px !important;
        font-weight: 600;
    }

    .section-header {
        padding: 15px 20px;
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header i {
        font-size: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    #citaCalendar {
        background: white;
        padding: 15px;
        border-radius: 8px;
    }

    .calendar-legend {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 3px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-calendar-check"></i> Gestión de Citas</h2>
                <a href="{{ route('cita.create') }}" class="btn btn-success add-cita-btn">
                    <i class="fas fa-plus"></i> Añadir Cita
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- calendario -->
        <div class="col-lg-8 mb-4">
            <div class="calendar-container">
                <div class="section-header">
                    <i class="fas fa-calendar-alt"></i>
                    <h5 class="mb-0">Calendario de Citas</h5>
                </div>
                <div id="citaCalendar"></div>
                <div class="calendar-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background: #3788d8;"></div>
                        <span>Cita Programada</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: #ff9f89;"></div>
                        <span>Cita Cancelada</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- proximas citas -->
        <div class="col-lg-4 mb-4">
            <div class="activities-section">
                <div class="section-header">
                    <i class="fas fa-list-check"></i>
                    <h5 class="mb-0">Próximas Actividades</h5>
                </div>
                <div style="padding: 20px;">
                    @if($citas->where('estatus', '!=', 'cancelada')->count() > 0)
                        @foreach($citas->where('estatus', '!=', 'cancelada')->take(5) as $c)
                            <div class="activity-item">
                                <div class="activity-header">
                                    <div>
                                        <div class="activity-title">{{ $c->paciente }}</div>
                                        <div class="activity-meta">
                                            <i class="fas fa-user-md"></i> {{ $c->fisio }}
                                        </div>
                                    </div>
                                    <span class="status-badge status-{{ $c->estatus }}">{{ ucfirst($c->estatus) }}</span>
                                </div>
                                <div class="activity-meta">
                                    <i class="fas fa-calendar"></i> {{ date('d/m/Y', strtotime($c->fecha)) }} - {{ substr($c->hora, 0, 5) }}
                                </div>
                                @if($c->motivo)
                                    <div class="activity-meta">
                                        <i class="fas fa-notes-medical"></i> {{ Str::limit($c->motivo, 40) }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No hay citas próximas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- tabla de citas -->
    <div class="row">
        <div class="col-12">
            <div class="activities-section">
                <div class="section-header">
                    <i class="fas fa-table"></i>
                    <h5 class="mb-0">Todas las Citas</h5>
                </div>
                <div style="overflow-x: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Paciente</th>
                                <th>Fisioterapeuta</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Motivo</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($citas as $c)
                                <tr class="{{ $c->estatus === 'cancelada' ? 'table-secondary' : '' }}">
                                    <td><strong>#{{ $c->id_cita }}</strong></td>
                                    <td>{{ $c->paciente }}</td>
                                    <td>{{ $c->fisio }}</td>
                                    <td>{{ date('d/m/Y', strtotime($c->fecha)) }}</td>
                                    <td>{{ substr($c->hora, 0, 5) }}</td>
                                    <td>{{ Str::limit($c->motivo ?? '-', 30) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $c->estatus === 'cancelada' ? 'danger' : ($c->estatus === 'completada' ? 'success' : 'info') }}">
                                            {{ ucfirst($c->estatus) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-action-group">
                                                <a href="{{ route('cita.show', $c->id_cita) }}" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <a href="{{ route('cita.edit', $c->id_cita) }}" class="btn btn-sm btn-outline-warning" title="Modificar">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @if($c->estatus !== 'cancelada')
                                                <form action="{{ route('cita.cancelar', $c->id_cita) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Cancelar" onclick="if(confirm('¿Cancelar esta cita?')) this.form.submit();">
                                                        <i class="fas fa-times-circle"></i> Cancelar
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('cita.destroy', $c->id_cita) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="if(confirm('¿Eliminar esta cita de forma permanente?')) this.form.submit();">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox"></i> No hay citas registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- fullcalendar -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('citaCalendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: function(info, successCallback, failureCallback) {
                fetch('{{ route("cita.events") }}')
                    .then(response => response.json())
                    .then(data => successCallback(data))
                    .catch(error => failureCallback(error));
            },
            eventClick: function(info) {
                alert('Cita: ' + info.event.title + '\nMotivo: ' + info.event.extendedProps.motivo);
            }
        });
        calendar.render();
    });
</script>

@endsection
