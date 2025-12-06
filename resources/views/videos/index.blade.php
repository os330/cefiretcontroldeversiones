<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Lista de Videos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        
        .video-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .video-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .video-desc {
            color: #666;
            margin-bottom: 15px;
        }
        
        .video-url {
            color: #2e86c1;
            text-decoration: none;
            font-size: 14px;
        }
        
        .video-url:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Videos Registrados</h1>
        
        <a href="{{ route('videos.create') }}" class="btn btn-primary mb-4">
            <i class="fas fa-plus"></i> Nuevo Video
        </a>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($videos->isEmpty())
            <div class="alert alert-info">
                No hay videos registrados aún.
            </div>
        @else
            @foreach($videos as $video)
                <div class="video-card">
                    <div class="video-title">{{ $video->titulo }}</div>
                    <div class="video-desc">{{ $video->descripcion }}</div>
                    <a href="{{ $video->url }}" target="_blank" class="video-url">
                        <i class="fab fa-youtube"></i> {{ $video->url }}
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>