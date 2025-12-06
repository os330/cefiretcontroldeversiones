<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Registrar Video / Ejercicio</title>

    <!-- SweetAlert2 -->
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .panel {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            border-color: #2e86c1;
            box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.2);
            outline: none;
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .btn {
            margin-top: 25px;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        
        .btn-guardar {
            background: #2e86c1;
            color: white;
        }
        
        .btn-guardar:hover {
            background: #23638f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(35, 99, 143, 0.3);
        }
        
        .btn-cancelar {
            background: #7f8c8d;
            color: white;
            margin-left: 10px;
        }
        
        .btn-cancelar:hover {
            background: #636e72;
            transform: translateY(-2px);
        }
        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-top: 40px;
            font-weight: 700;
        }
        
        @media (max-width: 768px) {
            .panel {
                width: 90%;
                padding: 20px;
            }
        }
        
        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .is-invalid {
            border-color: #e74c3c !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h1>
            <i class="fas fa-video" style="color: #2e86c1; margin-right: 10px;"></i>
            Registrar Video / Ejercicio
        </h1>

        <div class="panel">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: '{{ session('success') }}',
                            timer: 1800,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('videos.index') }}";
                        });
                    });
                </script>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('videos.store') }}">
                @csrf

                <div class="form-group">
                    <label for="titulo" class="form-label">
                        <i class="fas fa-heading"></i> Título del video *
                    </label>
                    <input type="text" 
                           id="titulo" 
                           name="titulo" 
                           class="form-control @error('titulo') is-invalid @enderror" 
                           value="{{ old('titulo') }}" 
                           required
                           placeholder="Ej: Ejercicios de flexibilidad para piernas">
                    
                    @error('titulo')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">
                        <i class="fas fa-align-left"></i> Descripción *
                    </label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3" 
                              required
                              placeholder="Describe el ejercicio, indicaciones importantes, precauciones...">{{ old('descripcion') }}</textarea>
                    
                    @error('descripcion')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="url" class="form-label">
                        <i class="fab fa-youtube"></i> URL del video (YouTube) *
                    </label>
                    <input type="text" 
                           id="url" 
                           name="url" 
                           class="form-control @error('url') is-invalid @enderror" 
                           value="{{ old('url') }}" 
                           placeholder="https://youtube.com/..." 
                           required>
                    
                    @error('url')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    
                    <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                        Ejemplo: https://www.youtube.com/watch?v=abc123 o https://youtu.be/abc123
                    </small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-guardar">
                        <i class="fas fa-save"></i> Guardar Video
                    </button>
                    
                    <a href="{{ route('rutinas.asignar') }}" class="btn btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlInput = document.getElementById('url');
            const videoPreview = document.createElement('div');
            videoPreview.id = 'video-preview';
            videoPreview.style.marginTop = '15px';
            urlInput.parentNode.appendChild(videoPreview);

            urlInput.addEventListener('input', function() {
                const url = this.value;
                let videoId = '';

                if (url.includes('youtube.com/watch?v=')) {
                    videoId = url.split('v=')[1];
                    const ampersandPosition = videoId.indexOf('&');
                    if (ampersandPosition !== -1) {
                        videoId = videoId.substring(0, ampersandPosition);
                    }
                } else if (url.includes('youtu.be/')) {
                    videoId = url.split('youtu.be/')[1];
                    const ampersandPosition = videoId.indexOf('&');
                    if (ampersandPosition !== -1) {
                        videoId = videoId.substring(0, ampersandPosition);
                    }
                }

                if (videoId && /^[a-zA-Z0-9_-]{11}$/.test(videoId)) {
                    videoPreview.innerHTML = `
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 2px dashed #ddd;">
                            <p style="font-weight: 600; color: #2c3e50; margin-bottom: 10px;">
                                <i class="fas fa-eye"></i> Vista previa:
                            </p>
                            <div style="position:relative; padding-bottom:56.25%; height:0;">
                                <iframe 
                                    src="https://www.youtube.com/embed/${videoId}" 
                                    style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <p style="margin-top: 10px; font-size: 12px; color: #7f8c8d;">
                                ID: ${videoId}
                            </p>
                        </div>
                    `;
                } else {
                    videoPreview.innerHTML = '';
                }
            });

            document.querySelector('form').addEventListener('submit', function(e) {
                const url = urlInput.value;
                
                if (!url.includes('youtube.com') && !url.includes('youtu.be')) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'URL inválida',
                        text: 'Por favor ingresa una URL válida de YouTube',
                        confirmButtonText: 'Entendido'
                    });
                }
            });
        });
    </script>
</body>
</html>