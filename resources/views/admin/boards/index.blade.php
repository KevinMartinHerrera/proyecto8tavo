@extends('layouts.admin')

@section('title')
<title>RMJuridico | Tableros</title>
@endsection

@section('ruta')
  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Inicio</a></li>
  <li class="breadcrumb-item active">Tableros</li> 
@endsection

@section('seccion')
  <h1 class="m-0">Tableros</h1>
@endsection

@section('container')
<div class="container-fluid">
    <div class="header-container mb-4">
        <h2 class="header-title">Administración de Tableros</h2>
        <button class="btn btn-primary create-board-btn" data-bs-toggle="modal" data-bs-target="#createBoardModal">Crear Tablero</button>
    </div>
    <div class="board-container">
        @foreach ($boards as $board)
            <div class="board-card">
                <a href="{{ route('boards.show', $board->id) }}" class="board-title">{{ $board->name }}</a>
                <div class="board-actions">
                    <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editBoardModal-{{ $board->id }}">Editar</button>
                    <form  id="miFormulario{{ $board->id  }}" action="{{ route('boards.destroy', $board->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm delete-btn" onclick="preguntar{{ $board->id }}(event)">Eliminar</button>
                    </form>
                    <script>
                        function preguntar{{ $board->id }}(event) {
                            event.preventDefault();
                            Swal.fire({
                                title: 'Eliminar tablero',
                                text: '¿Desea eliminar este tablero ?',
                                icon: 'question',
                                showDenyButton: true,
                                confirmButtonText: 'Eliminar',
                                confirmButtonColor: '#a5161d',
                                denyButtonColor: '#270a0a',
                                denyButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var form = document.getElementById('miFormulario{{ $board->id }}');
                                    form.submit();
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Create Board Modal -->
<div class="modal fade" id="createBoardModal" tabindex="-1" aria-labelledby="createBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBoardModalLabel">Crear Tablero</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('boards.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="boardName" class="form-label">Nombre del Tablero</label>
                        <input type="text" class="form-control" id="boardName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Board Modals -->
@foreach ($boards as $board)
<div class="modal fade" id="editBoardModal-{{ $board->id }}" tabindex="-1" aria-labelledby="editBoardModalLabel-{{ $board->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBoardModalLabel-{{ $board->id }}">Editar Tablero</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('boards.update', $board->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editBoardName-{{ $board->id }}" class="form-label">Nombre del Tablero</label>
                        <input type="text" class="form-control" id="editBoardName-{{ $board->id }}" name="name" value="{{ $board->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #343a40;
        margin: 0;
    }

    .create-board-btn {
        background: linear-gradient(135deg, #6b73ff, #000dff);
        border: none;
        padding: 12px 24px;
        font-size: 18px;
        transition: all 0.3s ease;
        border-radius: 10px;
        text-transform: uppercase;
    }

    .create-board-btn:hover {
        background: linear-gradient(135deg, #000dff, #6b73ff);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .board-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .board-card {
        background: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 300px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .board-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .board-title {
        font-size: 22px;
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
        background: linear-gradient(135deg, #6b73ff, #000dff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 10px;
    }

    .board-title:hover {
        background: linear-gradient(135deg, #000dff, #6b73ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .board-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .board-actions .btn {
        margin: 0;
        padding: 10px 20px;
        font-size: 14px;
        transition: all 0.3s ease;
        border-radius: 8px;
        text-transform: uppercase;
    }

    .edit-btn {
        background: linear-gradient(135deg, #ffcf33, #ff8c00);
        color: #fff;
    }

    .edit-btn:hover {
        background: linear-gradient(135deg, #ff8c00, #ffcf33);
        color: #fff;
        transform: translateY(-2px);
    }

    .delete-btn {
        background: linear-gradient(135deg, #ff3d71, #ff0000);
        color: #fff;
    }

    .delete-btn:hover {
        background: linear-gradient(135deg, #ff0000, #ff3d71);
        color: #fff;
        transform: translateY(-2px);
    }

    .modal-dialog {
        max-width: 600px;
        margin: 1.75rem auto;
    }

    .modal-content {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #007bff;
        color: #fff;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: none;
        padding: 15px 20px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6b73ff, #000dff);
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        transition: all 0.3s ease;
        border-radius: 10px;
        text-transform: uppercase;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #000dff, #6b73ff);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 10px;
    }

    .btn-close {
        color: #fff;
        opacity: 1;
    }
</style>
@endsection

@section('scripts')
<!-- Incluye los scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection