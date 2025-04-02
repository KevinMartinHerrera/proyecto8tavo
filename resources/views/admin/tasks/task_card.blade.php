<!-- resources/views/admin/tasks/task_card.blade.php -->
<div class="task-card" data-task-id="{{ $task->id }}" draggable="true">
    <div class="card task-card-body">
        <div class="card-body">
            <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-text">{{ $task->description }}</p>
            <div class="task-meta">
                <div class="task-meta-item">
                    <strong>Creado por:</strong> {{ $task->creator->name }}
                </div>
                <div class="task-meta-item">
                    <strong>Asignado a:</strong> {{ $task->assignee ? $task->assignee->name : 'Sin asignar' }}
                </div>
            </div>
            <div class="action-buttons mt-3">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

