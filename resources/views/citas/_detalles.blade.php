<div class="cita-detalles">
    <h5>Detalles de la Cita #{{ $cita->id_cita }}</h5>
    
    <table class="table table-sm">
        <tr>
            <th width="30%">Fecha:</th>
            <td>{{ date('d/m/Y', strtotime($cita->fecha)) }}</td>
        </tr>
        <tr>
            <th>Hora:</th>
            <td>{{ date('H:i', strtotime($cita->hora)) }}</td>
        </tr>
        <tr>
            <th>Paciente:</th>
            <td>{{ $cita->paciente_nombre ?? 'N/A' }} {{ $cita->paciente_apaterno ?? '' }}</td>
        </tr>
        <tr>
            <th>Fisioterapeuta:</th>
            <td>{{ $cita->fisio_nombre ?? 'N/A' }} {{ $cita->fisio_apaterno ?? '' }}</td>
        </tr>
        <tr>
            <th>Estatus:</th>
            <td>
                @php
                    $colorEstatus = [
                        'pendiente' => 'warning',
                        'confirmada' => 'success',
                        'completada' => 'info',
                        'cancelada' => 'danger'
                    ][$cita->estatus] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $colorEstatus }}">
                    {{ ucfirst($cita->estatus) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Motivo:</th>
            <td>{{ $cita->motivo }}</td>
        </tr>
        @if($cita->observaciones)
        <tr>
            <th>Observaciones:</th>
            <td>{{ $cita->observaciones }}</td>
        </tr>
        @endif
    </table>
    
    <div class="text-end mt-3">
        <a href="{{ route('citas.edit', $cita->id_cita) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Editar
        </a>
        @if($cita->estatus != 'cancelada')
            <form action="{{ route('citas.cancelar', $cita->id_cita) }}" 
                  method="POST" class="d-inline"
                  onsubmit="return confirm('¿Cancelar esta cita?')">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-times-circle"></i> Cancelar
                </button>
            </form>
        @endif
    </div>
</div>