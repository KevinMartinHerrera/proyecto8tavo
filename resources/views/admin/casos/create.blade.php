@extends('layouts.admin')

@section('title')
    <title>RMJuridico | Crear Casos</title>
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('casos.index') }}">Administrador de Casos</a></li>
    <li class="breadcrumb-item active">Crear Caso</li>
@endsection


@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0">Formulario de Creación de Caso</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('casos.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="numero_caso" class="form-label">Número de Caso</label>
                                    <input type="text" class="form-control" id="numero_caso" name="numero_caso" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_apertura" class="form-label">Fecha de Apertura</label>
                                    <input type="date" class="form-control" id="fecha_apertura" name="fecha_apertura" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label">Descripción del Caso</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_caso" class="form-label">Tipo de Caso</label>
                                    <input type="text" class="form-control" id="tipo_caso" name="tipo_caso" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado del Caso</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="">Seleccionar Estado</option>
                                        <option value="Abierto">Abierto</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="Cerrado">Cerrado</option>
                                        <option value="Archivado">Archivado</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numero_expediente" class="form-label">Número de Expediente</label>
                                    <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="abogado_id" class="form-label">Abogado</label>
                                    <select class="form-control" id="abogado_id" name="abogado_id" required>
                                        <option value="">Seleccionar Abogado</option>
                                        @foreach($abogados as $abogado)
                                            <option value="{{ $abogado->id }}">{{ $abogado->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <select class="form-control" id="cliente_id" name="cliente_id" required>
                                        <option value="">Seleccionar Cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Crear Caso</button>
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