@extends('layouts.app')

@section('title', 'Detalles de Rutina - CEFIRET')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0"><i class="fas fa-info-circle"></i> Detalles de la Rutina</h4>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Información del Paciente</h5>
                    <div class="mb-3">
                        <strong>Nombre:</strong>
                        <p>{{ $rutina->nombre }} {{ $rutina->apaterno }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Fecha de asignación:</strong>
                        <p>{{ \Carbon\Carbon::parse($rutina->fecha_asignacion)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="text-primary mb-3"><i class="fab fa-youtube"></i> Información del Video</h5>
                    <div class="mb-3">
                        <strong>Título:</strong>
                        <p>
                            @if($rutina->titulo)
                                {{ $rutina->titulo }}
                            @else
                                <span class="text-muted">Sin video asignado</span>
                            @endif
                        </p>
                    </div>
                    @if($rutina->url)
                        <a href="{{ $rutina->url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                            <i class="fab fa-youtube"></i> Ver video
                        </a>
                    @endif
                </div>
            </div>

            <hr>

            <h5 class="text-primary mb-3"><i class="fas fa-dumbbell"></i> Detalles de Ejercicio</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <strong>Repeticiones:</strong>
                        <p>{{ $rutina->repeticiones ?? '—' }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <strong>Series:</strong>
                        <p>{{ $rutina->series ?? '—' }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <strong>Tiempo estimado:</strong>
                        <p>{{ $rutina->tiempo ? $rutina->tiempo . ' minutos' : '—' }}</p>
                    </div>
                </div>
            </div>

            <hr>

            <div class="mb-4">
                <h5 class="text-primary mb-3"><i class="fas fa-calendar"></i> Días Asignados</h5>
                @if (!empty($dias))
                    <div>
                        @foreach ($dias as $dia)
                            <span class="badge bg-info text-dark me-2 mb-2" style="font-size: 0.95rem; padding: 0.5rem 0.75rem;">{{ $dia }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Sin días asignados</p>
                @endif
            </div>

            <div class="mb-4">
                <h5 class="text-primary mb-3"><i class="fas fa-sticky-note"></i> Observaciones</h5>
                @if ($rutina->observaciones)
                    <div class="p-3 bg-light border rounded">
                        <p>{{ $rutina->observaciones }}</p>
                    </div>
                @else
                    <p class="text-muted">Sin observaciones</p>
                @endif
            </div>
            <a href="{{ route('rutinas.edit', $rutina->id_rutina) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-heartbeat"></i> Progreso del Paciente</h4>
        </div>

        <div class="card-body">
            <div class="row">
                
                </div>

                <div class="col-md-8">
                    <h6 class="text-success mb-3"><i class="fas fa-file-alt"></i> Informe de Progreso</h6>

                    <div id="informePlaceholder">
                        <div class="mb-3">
                            <strong>% de avance:</strong>
                            <div class="progress mt-2">
                                <div id="progressBar" class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Número de ejercicios:</strong>
                                <p id="numEjercicios">—</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Series realizadas:</strong>
                                <p id="seriesRealizadas">—</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Ejercicios ejecutados:</strong>
                                <p id="ejerciciosEjecutados">—</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Lista de ejercicios ejecutados:</strong>
                            <ul id="listaEjercicios" class="mt-2"></ul>
                        </div>

                        <div class="mb-3">
                            <strong>Observaciones:</strong>
                            <div id="observaciones" class="p-2 bg-light border rounded mt-2">Sin observaciones</div>
                        </div>

                        <div class="mt-3">
                            <button id="finalizarInformeBtn" class="btn btn-danger" disabled>Finalizar Informe</button>
                            <a href="{{ route('rutinas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        </div>
    </div>
    

</div>


@push('scripts')
<script>
    var progresoData = @json($progresos ?? (object)[]);

    (function(){
        var list = document.getElementById('pacienteList');
        var selectedId = null;
        var finalizarBtn = document.getElementById('finalizarInformeBtn');

        function clearSelection(){
            var items = list.querySelectorAll('.list-group-item');
            items.forEach(function(it){ it.classList.remove('active'); });
        }

        function renderInforme(data){
            var progressBar = document.getElementById('progressBar');
            var numEj = document.getElementById('numEjercicios');
            var series = document.getElementById('seriesRealizadas');
            var ejEjec = document.getElementById('ejerciciosEjecutados');
            var listaEj = document.getElementById('listaEjercicios');
            var obs = document.getElementById('observaciones');

            if(!data){
                progressBar.style.width = '0%';
                progressBar.setAttribute('aria-valuenow', 0);
                progressBar.textContent = '0%';
                numEj.textContent = '—';
                series.textContent = '—';
                ejEjec.textContent = '—';
                listaEj.innerHTML = '';
                obs.textContent = 'Sin observaciones';
                return;
            }

            var avance = parseInt(data.avance) || 0;
            progressBar.style.width = avance + '%';
            progressBar.setAttribute('aria-valuenow', avance);
            progressBar.textContent = avance + '%';

            numEj.textContent = data.num_ejercicios != null ? data.num_ejercicios : '—';
            series.textContent = data.series_realizadas != null ? data.series_realizadas : '—';
            ejEjec.textContent = (data.ejercicios_ejecutados && data.ejercicios_ejecutados.length) ? data.ejercicios_ejecutados.length : '—';

            listaEj.innerHTML = '';
            if(data.ejercicios_ejecutados && data.ejercicios_ejecutados.length){
                data.ejercicios_ejecutados.forEach(function(item){
                    var li = document.createElement('li');
                    li.textContent = item;
                    listaEj.appendChild(li);
                });
            }

            obs.textContent = data.observaciones || 'Sin observaciones';
        }

        list.addEventListener('click', function(e){
            var target = e.target;
            if(target && target.matches('.list-group-item')){
                e.preventDefault();
                clearSelection();
                target.classList.add('active');
                selectedId = target.getAttribute('data-id');
                var data = progresoData[selectedId] || null;
                renderInforme(data);
                finalizarBtn.disabled = false;
            }
        });

        finalizarBtn.addEventListener('click', function(){
            if(!selectedId){
                alert('Seleccione un paciente primero.');
                return;
            }
            if(!confirm('¿Desea finalizar el informe para este paciente?')) return;
            alert('Informe finalizado (simulado) para paciente ID: ' + selectedId);
        });
        renderInforme(null);
    })();
</script>
@endpush

@endsection
