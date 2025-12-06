@extends('layouts.app')

@section('title', 'Agendar Nueva Cita - CEFIRET')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus"></i> Agendar Nueva Cita
                    </h4>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('citas.store') }}" id="citaForm">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Seleccionar Paciente *
                                </label>
                                <select name="id_usuario" class="form-select" required>
                                    <option value="">Seleccionar paciente...</option>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id_usuario }}">
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
                                        <option value="{{ $fisio->id_usuario }}">
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
                                       value="{{ date('Y-m-d') }}" 
                                       required
                                       min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="far fa-clock"></i> Hora de la Cita *
                                </label>
                                <select name="hora" id="hora_cita" class="form-select" required>
                                    <option value="">Seleccionar hora...</option>
                                    <option value="08:00">08:00 AM</option>
                                    <option value="08:30">08:30 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="09:30">09:30 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="10:30">10:30 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="12:30">12:30 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="13:30">01:30 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="14:30">02:30 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="15:30">03:30 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                    <option value="16:30">04:30 PM</option>
                                    <option value="17:00">05:00 PM</option>
                                </select>
                                <small class="text-muted" id="horariosDisponiblesInfo"></small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-stethoscope"></i> Motivo de la Cita *
                                </label>
                                <textarea name="motivo" 
                                          class="form-control" 
                                          rows="3" 
                                          placeholder="Describa el motivo de la consulta..." 
                                          required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-clipboard"></i> Observaciones (opcional)
                                </label>
                                <textarea name="observaciones" 
                                          class="form-control" 
                                          rows="2" 
                                          placeholder="Observaciones adicionales..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-info-circle"></i> Estatus de la Cita *
                                </label>
                                <select name="estatus" class="form-select" required>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="confirmada">Confirmada</option>
                                    <option value="completada">Completada</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('citas.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-calendar-check"></i> Agendar Cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    console.log('Script de rutinas cargado');
    document.getElementById('video_url').addEventListener('input', function() {
        const url = this.value;
        const preview = document.getElementById('videoPreview');
        const previewContent = document.getElementById('previewContent');
        
        console.log('URL cambiada:', url);
        
        if (!url) {
            preview.style.display = 'none';
            return;
        }
        
        let videoId = '';
        if (url.includes('youtube.com/watch?v=')) {
            const match = url.match(/v=([a-zA-Z0-9_-]+)/);
            if (match) {
                videoId = match[1].split('&')[0];
                console.log('Video ID extraído:', videoId);
            }
        } else if (url.includes('youtu.be/')) {
            const match = url.match(/youtu\.be\/([a-zA-Z0-9_-]+)/);
            if (match) {
                videoId = match[1].split('&')[0];
                console.log('Video ID extraído:', videoId);
            }
        }
        if (videoId && /^[a-zA-Z0-9_-]{11}$/.test(videoId)) {
            console.log('Mostrando vista previa para ID:', videoId);
            previewContent.innerHTML = `
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/${videoId}" 
                            title="Vista previa del video" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
                <div class="mt-2 text-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Vista previa del video - ID: ${videoId}
                    </small>
                </div>
            `;
            preview.style.display = 'block';
        } else {
            console.log('No se pudo extraer ID válido');
            preview.style.display = 'none';
        }
    });
    document.getElementById('rutinaForm').addEventListener('submit', function(e) {
        console.log('Formulario enviándose...');
        
        const paciente = document.querySelector('select[name="id_paciente"]').value;
        const fecha = document.querySelector('input[name="fecha_asignacion"]').value;
        const videoTitulo = document.querySelector('input[name="video_titulo"]').value;
        const videoUrl = document.getElementById('video_url').value;
        const diasSeleccionados = document.querySelectorAll('input[name="dias[]"]:checked').length;
        
        console.log('Validando:', {
            paciente, fecha, videoTitulo, videoUrl, diasSeleccionados
        });
        
        if (!paciente) {
            e.preventDefault();
            console.error('Error: No hay paciente seleccionado');
            Swal.fire({
                icon: 'error',
                title: 'Paciente requerido',
                text: 'Por favor selecciona un paciente',
                confirmButtonText: 'Entendido'
            }).then(() => {
                document.querySelector('select[name="id_paciente"]').focus();
            });
            return;
        }
        
        if (!fecha) {
            e.preventDefault();
            console.error('Error: No hay fecha seleccionada');
            Swal.fire({
                icon: 'error',
                title: 'Fecha requerida',
                text: 'Por favor selecciona una fecha',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        
        if (!videoTitulo.trim()) {
            e.preventDefault();
            console.error('Error: No hay título de video');
            Swal.fire({
                icon: 'error',
                title: 'Título requerido',
                text: 'Por favor ingresa un título para el video',
                confirmButtonText: 'Entendido'
            }).then(() => {
                document.querySelector('input[name="video_titulo"]').focus();
            });
            return;
        }
        
        if (!videoUrl.includes('youtube.com') && !videoUrl.includes('youtu.be')) {
            e.preventDefault();
            console.error('Error: URL de YouTube inválida');
            Swal.fire({
                icon: 'error',
                title: 'URL inválida',
                text: 'Por favor ingresa una URL válida de YouTube',
                confirmButtonText: 'Entendido'
            }).then(() => {
                document.getElementById('video_url').focus();
            });
            return;
        }
        
        if (diasSeleccionados === 0) {
            e.preventDefault();
            console.error('Error: No hay días seleccionados');
            document.getElementById('diasError').style.display = 'block';
            Swal.fire({
                icon: 'warning',
                title: 'Días requeridos',
                text: 'Por favor selecciona al menos un día para la rutina',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        
        document.getElementById('diasError').style.display = 'none';
        
        console.log('Validación pasada, enviando formulario...');
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

        console.log('Formulario listo para enviar');
    });
    
    document.querySelectorAll('input[name="dias[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            console.log('Día cambiado:', this.value, this.checked);
            if (document.querySelectorAll('input[name="dias[]"]:checked').length > 0) {
                document.getElementById('diasError').style.display = 'none';
            }
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página de creación de rutina cargada');
        console.log('Pacientes disponibles:', @json($pacientes));
        
        document.querySelectorAll('input[name="dias[]"]').forEach(cb => {
            console.log('Checkbox:', cb.id, 'valor:', cb.value);
        });
    });
</script>
@endsection