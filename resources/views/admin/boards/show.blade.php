@extends('layouts.admin')

@section('title')
<title>RMJuridico | Detalles del Tablero</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('ruta')
  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Inicio</a></li>
  <li class="breadcrumb-item"><a href="{{ route('boards.index') }}">Tableros</a></li>
  <li class="breadcrumb-item active">{{ $board->name }}</li> 
@endsection

@section('seccion')
  <h1 class="m-0">Tablero</h1>
@endsection

@section('container')
<div class="container-fluid">
    <div class="header-container mb-4">
        <h2 class="header-title">{{ $board->name }}</h2>
        <button class="btn btn-primary create-task-btn" data-bs-toggle="modal" data-bs-target="#createTaskModal">Crear Tarea</button>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">Por hacer</div>
                <div class="card-body task-list" data-status="todo">
                    @foreach ($board->tasks()->where('status', 'todo')->get() as $task)
                        @include('admin.tasks.task_card', ['task' => $task])
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">En progreso</div>
                <div class="card-body task-list" data-status="in_progress">
                    @foreach ($board->tasks()->where('status', 'in_progress')->get() as $task)
                        @include('admin.tasks.task_card', ['task' => $task])
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light mb-3">
                <div class="card-header">Completadas</div>
                <div class="card-body task-list" data-status="done">
                    @foreach ($board->tasks()->where('status', 'done')->get() as $task)
                        @include('admin.tasks.task_card', ['task' => $task])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Crear Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="board_id" value="{{ $board->id }}">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Título de la Tarea</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">Estado</label>
                        <select class="form-select" id="taskStatus" name="status" required>
                            <option value="todo">Por hacer</option>
                            <option value="in_progress">En progreso</option>
                            <option value="done">Completada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="taskAssignee" class="form-label">Asignar a</label>
                        <select class="form-select" id="taskAssignee" name="assignee_id">
                            <option value="">Sin asignar</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Task Details -->

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

        .create-task-btn {
            background: linear-gradient(135deg, #6b73ff, #000dff);
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            transition: all 0.3s ease;
            border-radius: 10px;
            text-transform: uppercase;
        }

        .create-task-btn:hover {
            background: linear-gradient(135deg, #000dff, #6b73ff);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 12px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            font-weight: bold;
        }

        .task-list {
            min-height: 300px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .task-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px; /* Increased margin bottom for spacing */
            position: relative; /* Add position relative for absolute positioning */
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333333;
            margin-bottom: 8px; /* Adjusted margin for tighter spacing */
        }

        .card-text {
            color: #666666;
            margin-bottom: 12px; /* Adjusted margin for tighter spacing */
        }

        .task-meta {
            display: flex;
            justify-content: space-between;
            color: #999999;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .task-meta-item {
            flex: 1;
        }

        .action-buttons {
            margin-top: 12px; /* Increased top margin for spacing */
        }

        .btn {
            padding: 8px; /* Slightly reduced padding */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn i {
            margin-right: 5px; /* Add margin-right for spacing between icon and text */
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }

        .btn-warning:hover, .btn-danger:hover {
            filter: brightness(90%);
        }
    </style>
@endsection



@section('scripts')
<!-- Incluye los scripts de Bootstrap y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Manejar el evento 'dragstart' para marcar la tarjeta como arrastrándose
        $('.task-card').on('dragstart', function (event) {
            $(this).addClass('dragging');
        });

        // Manejar el evento 'dragover' para prevenir comportamiento por defecto
        $('.task-list').on('dragover', function (event) {
            event.preventDefault();
        });

        // Manejar el evento 'drop' para mover la tarea
        $('.task-list').on('drop', function (event) {
            event.preventDefault();
            
            // Obtener el ID de la tarea que se está arrastrando
            var taskId = $('.dragging').data('task-id');
            
            // Obtener el nuevo estado de la tarea desde el contenedor de la lista
            var newStatus = $(this).data('status');
            
            // Obtener el token CSRF del meta tag
            var token = $('meta[name="csrf-token"]').attr('content');

            
            // Realizar una solicitud AJAX para mover la tarea
            $.ajax({
                url: '/tasks/' + taskId + '/move',
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    status: newStatus
                },
                success: function (response) {
                    console.log(response); // Depurar la respuesta del servidor
                    location.reload(); // Recargar la página después de una operación exitosa
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al mover la tarea.');
                }
            });
        });
    });
</script>

@endsection