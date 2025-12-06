@extends('layouts.app')

@section('title', 'Rutinas - CEFIRET')

@section('content')
<div class="container mt-4">

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

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-dumbbell"></i> Gestión de Rutinas</h4>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h5>Rutinas Asignadas</h5>
                    <p class="text-muted">Administra las rutinas con videos para cada paciente.</p>
                </div>

                <div>
                    <a href="{{ route('rutinas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Rutina
                    </a>
                </div>
            </div>

            @if($rutinas->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-dumbbell fa-4x text-muted mb-3"></i>
                    <h4>No hay rutinas registradas</h4>
                    <a href="{{ route('rutinas.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Crear primera rutina
                    </a>
                </div>

            @else

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Video</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rutinas as $r)
                        <tr>
                            <td><strong>#{{ $r->id_rutina }}</strong></td>

                            <td>{{ $r->nombre }} {{ $r->apaterno }}</td>

                            <td>{{ date('d/m/Y', strtotime($r->fecha_asignacion)) }}</td>

                            <td>
                                @if($r->video_titulo)

                                    <a href="{{ $r->video_url ?? '#' }}" target="_blank" class="badge bg-danger text-decoration-none">

                                        <i class="fab fa-youtube"></i> {{ Str::limit($r->video_titulo, 22) }}
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Sin video</span>
                                @endif
                            </td>

                            <td>
                                <div class="btn-group">

                                    <a href="{{ route('rutinas.edit', $r->id_rutina) }}"
                                       class="btn btn-sm btn-outline-primary">Editar
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="{{ route('rutinas.show', $r->id_rutina) }}"
                                       class="btn btn-sm btn-outline-info">Ver detalles
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('rutinas.destroy', $r->id_rutina) }}"
                                          method="POST" onsubmit="return confirm('¿Seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger ms-1">Eliminar
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
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
</div>
@endsection
