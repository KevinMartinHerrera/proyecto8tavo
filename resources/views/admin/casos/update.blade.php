@extends('layouts.admin')

@section('title')
    <title>Editar Caso</title>
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('casos.index') }}">Administrador de Casos</a></li>
    <li class="breadcrumb-item active">Editar Caso</li>
@endsection

@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0">Formulario de Edición de Caso</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('casos.update', $caso->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="numero_caso" class="form-label">Número de Caso</label>
                                    <input type="text" class="form-control" id="numero_caso" name="numero_caso" value="{{ old('numero_caso', $caso->numero_caso) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_cierre" class="form-label">Fecha de Cierre</label>
                                    <input type="date" class="form-control" id="fecha_cierre" name="fecha_cierre" value="{{ old('fecha_cierre', $caso->fecha_cierre ? $caso->fecha_cierre->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label">Descripción del Caso</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $caso->descripcion) }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_caso" class="form-label">Tipo de Caso</label>
                                    <input type="text" class="form-control" id="tipo_caso" name="tipo_caso" value="{{ old('tipo_caso', $caso->tipo_caso) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado del Caso</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="">Seleccionar Estado</option>
                                        <option value="Abierto" {{ old('estado', $caso->estado) === 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                        <option value="En proceso" {{ old('estado', $caso->estado) === 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                        <option value="Cerrado" {{ old('estado', $caso->estado) === 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                        <option value="Archivado" {{ old('estado', $caso->estado) === 'Archivado' ? 'selected' : '' }}>Archivado</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numero_expediente" class="form-label">Número de Expediente</label>
                                    <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" value="{{ old('numero_expediente', $caso->numero_expediente) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="abogado_id" class="form-label">Abogado</label>
                                    <input type="text" class="form-control" id="abogado_id" name="abogado_id" value="{{ $caso->abogado->name }}" readonly>
                                    <input type="hidden" name="abogado_id" value="{{ $caso->abogado_id }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <input type="text" class="form-control" id="cliente_id" name="cliente_id" value="{{ $caso->cliente->name }}" readonly>
                                    <input type="hidden" name="cliente_id" value="{{ $caso->cliente_id }}">
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .form-control:not(textarea) {
            height: calc(2.5rem + 2px); /* Ajustar altura para todos los inputs menos el textarea */
        }

        textarea {
            resize: none; /* Evitar redimensionamiento del textarea */
            min-height: 120px; /* Altura mínima del textarea */
        }

        .card-header {
            background-color: #4e73df; /* Color de fondo del header */
            color: white; /* Color de texto del header */
            border-bottom: 0; /* Quitar borde inferior */
        }

        .card-body {
            padding: 1.5rem; /* Aumentar espacio interno del cuerpo de la tarjeta */
        }

        .form-label {
            font-weight: bold; /* Texto del label en negrita */
        }

        .btn-primary {
            background-color: #4e73df; /* Color de fondo del botón */
            border-color: #4e73df; /* Color del borde del botón */
        }

        .btn-primary:hover {
            background-color: #375abb; /* Color de fondo del botón al pasar el mouse */
            border-color: #375abb; /* Color del borde del botón al pasar el mouse */
        }

        .text-end {
            text-align: right; /* Alinear texto a la derecha */
        }
    </style>
@endsection
