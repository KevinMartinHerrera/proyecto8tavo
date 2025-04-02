@extends('layouts.admin')

@section('title')
    <title>RMJuridico | Gestor de Archivos</title>
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Gestor de Archivos</li>
@endsection

@section('seccion')
    <h1 class="m-0">Gestor de Archivos</h1>
@endsection

@section('container')
<div class="container">
    <!-- Botón para agregar una nueva carpeta -->
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaCarpetaModal">
            <i class="fas fa-folder-plus"></i> Nueva Carpeta
        </button>
    </div>

    <!-- Modal para crear una nueva carpeta -->
    <div class="modal fade" id="nuevaCarpetaModal" tabindex="-1" aria-labelledby="nuevaCarpetaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCarpetaModalLabel">Crear Nueva Carpeta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('carpetas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombreCarpeta" class="form-label">Nombre de la Carpeta</label>
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <input type="text" class="form-control" id="nombreCarpeta" name="nombre" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de carpetas en formato de tarjetas -->
    <div class="row">
        @foreach($carpetas as $carpeta)
        <div class="col-md-3 mb-4">
            <div class="card folder-card">
                <div class="card-body">
                    <div class="dropdown dropdown-end">
                        <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButton{{ $carpeta->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $carpeta->id }}">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editarCarpetaModal{{ $carpeta->id }}"><i class="fas fa-edit me-2"></i>Editar</a></li>
                            <li>
                                <form action=" {{ route('carpetas.destroy', $carpeta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta carpeta?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $carpeta->id }}">
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt me-2"></i>Eliminar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('carpetas.show', $carpeta->id) }}" class="folder-link" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver detalles de {{ $carpeta->nombre }}">
                        <div class="folder-icon mb-3 text-center">
                            <i class="fas fa-folder fa-5x"></i>
                        </div>
                        <div class="folder-name text-center">
                            {{ $carpeta->nombre }}
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal para editar carpeta -->
        <div class="modal fade" id="editarCarpetaModal{{ $carpeta->id }}" tabindex="-1" aria-labelledby="editarCarpetaModalLabel{{ $carpeta->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarCarpetaModalLabel{{ $carpeta->id }}">Editar Carpeta {{ $carpeta->nombre }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('carpetas.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="text" value="{{ $carpeta->id }}" name="id" hidden>
                                <label for="nombreCarpeta{{ $carpeta->id }}" class="form-label">Nombre de la Carpeta</label>
                                <input type="text" class="form-control" id="nombreCarpeta{{ $carpeta->id }}" name="nombre" value="{{ $carpeta->nombre }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .folder-card {
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .folder-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .folder-icon {
        color: #ffc107;
    }
    .folder-link {
        text-decoration: none;
        color: inherit;
    }
    .folder-name {
        font-weight: bold;
        color: #343a40;
    }
</style>
@endsection

@section('scripts')
<!-- Incluye los scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Inicialización de tooltips de Bootstrap -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection
