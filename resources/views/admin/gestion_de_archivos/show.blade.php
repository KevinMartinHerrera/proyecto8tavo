@extends('layouts.admin')

@section('title')
    <title>RMJuridico | {{ $carpeta->nombre }}</title>
      {{-- dropzone --}}
      <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
      <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('carpetas.index') }}">Gestor de Archivos</a></li>
    <li class="breadcrumb-item active">{{ $carpeta->nombre }}</li>
@endsection

@section('container')

<div class="container">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold">{{ $carpeta->nombre }}</h2>
        </div>
        <div class="col-auto">
            <div class="btn-group">
                <!-- Botón para agregar un nuevo archivo -->
                <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#nuevoArchivoModal">
                    <i class="fas fa-file-upload me-2"></i> Subir Archivo
                </button>
                <!-- Botón para crear una nueva carpeta -->
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaCarpetaModal">
                    <i class="fas fa-folder-plus me-2"></i> Nueva Carpeta
                </button>
            </div>
        </div>
    </div>
    <hr>

    <!-- Subcarpetas -->
        <div class="row">
            @foreach ($subcarpetas as $subcarpeta)
                <div class="col-md-3 mb-4">
                    <div class="card archivo-card">
                        <div class="card-body">
                            <div class="dropdown dropdown-end">
                                <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButton{{ $subcarpeta->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $subcarpeta->id }}">
                                    <li><a class="dropdown-item" href="{{ route('carpetas.show', $subcarpeta->id) }}"><i class="fas fa-folder-open me-2"></i>Abrir</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editarCarpetaModal{{ $subcarpeta->id }}"><i class="fas fa-edit me-2"></i>Editar</a></li>
                                    <li>
                                        <form action="{{ route('carpetas.destroy', $subcarpeta->id) }}" method="POST" id="eliminarCarpeta{{ $subcarpeta->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" value="{{$subcarpeta->id}}" name="id" hidden>
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-trash-alt me-2"></i>Eliminar
                                            </button>
                                        </form>                                        
                                    </li>

                                </ul>
                            </div>
                            <a href="{{ route('carpetas.show', ['id' => $subcarpeta->id]) }}" class="archivo-link" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver detalles de {{ $subcarpeta->nombre }}">
                                <div class="archivo-icon mb-3 text-center">
                                    <i class="fas fa-folder fa-3x"></i>
                                </div>
                                <div class="archivo-name text-center">
                                    {{ $subcarpeta->nombre }}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar carpeta -->
                <div class="modal fade" id="editarCarpetaModal{{ $subcarpeta->id }}" tabindex="-1" aria-labelledby="editarCarpetaModalLabel{{ $subcarpeta->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarCarpetaModalLabel{{ $subcarpeta->id }}">Editar Carpeta {{ $subcarpeta->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('carpetas.update', $subcarpeta->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="nombreCarpeta{{ $subcarpeta->id }}" class="form-label">Nombre de la Carpeta</label>
                                        <input type="text" class="form-control" id="nombreCarpeta{{ $subcarpeta->id }}" name="nombre" value="{{ $subcarpeta->nombre }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- archivos --}}
        <div class="row">
            @foreach ($archivos as $archivo)
                @php
                    // Obtener la extensión del archivo
                    $nombre = $archivo->nombre;
                    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
                
                    // Determinar el icono del archivo basado en su extensión
                    $icono = 'fas fa-file-alt'; // Icono por defecto
                    if ($extension === 'pdf') {
                        $icono = 'fas fa-file-pdf text-danger';
                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $icono = 'fas fa-file-image text-primary';
                    } elseif (in_array($extension, ['doc', 'docx'])) {
                        $icono = 'fas fa-file-word text-primary';
                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                        $icono = 'fas fa-file-excel text-success';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mkv', 'mov'])) {
                        $icono = 'fas fa-file-video text-warning';
                    } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                        $icono = 'fas fa-file-audio text-info';
                    }
                @endphp
        
                <div class="col-md-3 mb-4">
                    <div class="card archivo-card">
                        <div class="card-body">
                            <!-- Dropdown en la esquina superior derecha -->
                            <div class="dropdown dropdown-end">
                                <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButtonArchivo{{ $archivo->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButtonArchivo{{ $archivo->id }}">
                                    <li><a class="dropdown-item" href="{{ asset('storage/' . $carpeta->id . '/' . $archivo->nombre) }}"><i class="fas fa-download me-2"></i>Descargar</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#visualizarArchivoModal{{ $archivo->id }}"><i class="fas fa-eye me-2"></i>Visualizar</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#compartirArchivoModal{{ $archivo->id }}"><i class="fas fa-share-alt me-2"></i>Compartir</a></li>
                                    <li>
                                        <form action="{{ route('archivos.destroy' )}}" method="POST" id="miFormulario{{ $archivo->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" value="{{$archivo->id}}" name="id" hidden>
                                            <button type="button" onclick="preguntar{{ $archivo->id }}(event)" class="dropdown-item"><i class="fas fa-trash-alt me-2"></i>Eliminar</button>
                                        </form>
                                        <script>
                                            function preguntar{{$archivo->id}}(event) {
                                                event.preventDefault();
                                                Swal.fire({
                                                    title: 'Eliminar Archivo',
                                                    text: '¿Desea eliminar este Archivo?',
                                                    icon: 'question',
                                                    showDenyButton: true,
                                                    confirmButtonText: 'Eliminar',
                                                    confirmButtonColor: '#a5161d',
                                                    denyButtonColor: '#270a0a',
                                                    denyButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        var form = $('#miFormulario{{ $archivo->id }}');
                                                        form.submit();
                                                    }
                                                });
                                            }
                                        </script>
                                    </li>
                                </ul>
                            </div>
                            <!-- Icono de archivo -->
                            <div class="archivo-icon mb-3 text-center">
                                <i class="{{ $icono }} fa-3x"></i>
                            </div>
                            <!-- Nombre del archivo -->
                            <div class="archivo-name text-center">
                                {{ $archivo->nombre }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para visualizar archivo -->
                <div class="modal fade" id="visualizarArchivoModal{{ $archivo->id }}" tabindex="-1" aria-labelledby="visualizarArchivoModalLabel{{ $archivo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="visualizarArchivoModalLabel{{ $archivo->id }}">{{ $archivo->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                @if ($extension === 'pdf')
                                    <iframe src="{{ asset('storage/' . $carpeta->id . '/' . $archivo->nombre) }}" width="100%" height="600px"></iframe>
                                @elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $carpeta->id . '/' . $archivo->nombre) }}" class="img-fluid" alt="{{ $archivo->nombre }}">
                                @elseif (in_array($extension, ['mp4', 'avi', 'mkv', 'mov']))
                                    <video controls width="100%">
                                        <source src="{{ asset('storage/' . $carpeta->id . '/' . $archivo->nombre) }}" type="video/{{ $extension }}">
                                        Tu navegador no soporta la reproducción de videos.
                                    </video>
                                @elseif (in_array($extension, ['mp3', 'wav', 'ogg']))
                                    <audio controls>
                                        <source src="{{ asset('storage/' . $carpeta->id . '/' . $archivo->nombre) }}" type="audio/{{ $extension }}">
                                        Tu navegador no soporta la reproducción de audio.
                                    </audio>
                                @else
                                    <div class="no-preview text-center">
                                        <i class="{{ $icono }} fa-3x mb-4"></i>
                                        <p class="text-muted">La vista previa no está disponible para este tipo de archivo.</p>
                                        <a href="{{ asset('storage/' . $carpeta->id . '/' . $archivo->nombre) }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-download me-2"></i>Descargar
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal para compartir archivo -->

                <div class="modal fade" id="compartirArchivoModal{{ $archivo->id }}" tabindex="-1" aria-labelledby="compartirArchivoModalLabel{{ $archivo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="compartirArchivoModalLabel{{ $archivo->id }}">Compartir Archivo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($archivo->estado_archivo === 'PRIVADO')
                                    <div class="mb-3">
                                        <label for="enlaceArchivo{{ $archivo->id }}" class="form-label">Enlace de acceso:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="enlaceArchivo{{ $archivo->id }}" value="{{ route('mostrar.archivos.privado', ['carpeta' => $carpeta->id, 'archivo' => $archivo->nombre]) }}" readonly>
                                            <button type="button" class="btn btn-outline-primary" onclick="copiarEnlace('{{ $archivo->id }}')"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <form id="cambiarEstadoForm{{ $archivo->id }}" action="{{ route('Archivos.cambio_estatus.publico') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $archivo->id }}">
                                        <button type="submit" class="btn btn-outline-primary">Cambiar a Público</button>
                                    </form>
                                @else
                                    <div class="mb-3">
                                        <label for="enlaceArchivo{{ $archivo->id }}" class="form-label">Enlace de acceso:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="enlaceArchivo{{ $archivo->id }}" value="{{ route('mostrar.archivos.privado', ['carpeta' => $carpeta->id, 'archivo' => $archivo->nombre]) }}" readonly>
                                            <button type="button" class="btn btn-outline-primary" onclick="copiarEnlace('{{ $archivo->id }}')"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <form id="cambiarEstadoForm{{ $archivo->id }}" action="{{ route('Archivos.cambio_estatus.privado') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $archivo->id }}">
                                        <button type="submit" class="btn btn-outline-primary">Cambiar a Privado</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>



    <!-- Botón de regreso dinámico -->
    <div class="mt-4">
        <button class="btn btn-secondary" id="backButton">
            <i class="fas fa-arrow-left me-2"></i> Regresar
        </button>
    </div>
    
</div>

<!-- Modal para subir un nuevo archivo -->
<div class="modal fade" id="nuevoArchivoModal" tabindex="-1" aria-labelledby="nuevoArchivoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoArchivoModalLabel">Subir Nuevo Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('archivos.upload') }}" method="POST" class="dropzone" id="myDropzone" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $carpeta->id }}">
                    <div class="fallback">
                        <input type="file" name="file" multiple>
                    </div>
                    <div class="dz-message needsclick">
                        <div class="mb-3">
                            <i class="fas fa-cloud-upload-alt fa-4x"></i>
                        </div>
                        <h4>Arrastra archivos aquí o haz clic para subir.</h4>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear una nueva carpeta -->
<div class="modal fade" id="nuevaCarpetaModal" tabindex="-1" aria-labelledby="nuevaCarpetaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaCarpetaModalLabel">Crear Nueva Carpeta en {{ $carpeta->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subcarpetas.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="carpeta_padre_id" value="{{ $carpeta->id }}">
                    <div class="mb-3">
                        <label for="nombreCarpeta" class="form-label">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" id="nombreCarpeta" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .archivo-card {
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .archivo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .archivo-icon {
        color: #6c757d;
    }
    .archivo-link {
        text-decoration: none;
        color: inherit;
    }
    .archivo-name {
        font-weight: bold;
        color: #343a40;
    }
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: white;
        min-height: 150px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .dropzone .dz-message {
        text-align: center;
        font-size: 1.5em;
    }
    .dropzone .dz-preview {
        margin: 5px;
    }
    .dropzone .dz-preview .dz-details {
        max-width: 200px;
        text-align: left;
    }
    .dropzone .dz-preview .dz-image {
        border-radius: 5px;
        overflow: hidden;
        max-height: 120px;
    }
    .dropzone .dz-preview .dz-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .dropzone .dz-preview .dz-remove {
        text-align: center;
        cursor: pointer;
        font-size: 1.2em;
        position: absolute;
        top: 10px;
        right: 10px;
        color: #f44336;
    }
    .archivo-card {
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .archivo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .archivo-icon {
        color: #6c757d;
    }
    .archivo-name {
        font-weight: bold;
        color: #343a40;
    }
    .no-preview {
        padding: 20px;
        border: 2px dashed #ddd;
        border-radius: 10px;
        background-color: #f8f9fa;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .btn-close {
        color: white;
    }
</style>
@endsection

@section('scripts')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para el botón de regreso dinámico -->
<script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.location.href = '{{ route("carpetas.index") }}'; // Cambia esto a la ruta donde quieres redirigir
    });
</script>


<!-- Inicialización de tooltips de Bootstrap -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>

<script>
    function copiarEnlace(id) {
        var enlace = document.getElementById('enlaceArchivo' + id);
        enlace.select();
        enlace.setSelectionRange(0, 99999); /* Para dispositivos móviles */
        document.execCommand('copy');
        alert('Enlace copiado: ' + enlace.value);
    }

</script>

@endsection
