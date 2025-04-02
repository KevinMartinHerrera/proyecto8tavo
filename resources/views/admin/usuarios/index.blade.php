@extends('layouts.admin')

@section('title')
    <title>RMJuridico | Usuarios</title>    
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Administrador de Usuarios</li> 
@endsection

@section('seccion')
    <h1 class="m-0">Gestión de Usuarios</h1>
@endsection

@section('container')
<div class="container">
    <!-- Barra de herramientas con el botón para agregar un nuevo usuario -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('usuario.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Agregar Nuevo Usuario
        </a>
    </div>

    <div class="table-responsive">
        <table id="usuarios-table" class="table table-hover table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <!-- Quitamos la columna de ID y mostramos numeración secuencial -->
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de Creación</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->created_at }}</td>
                    <td>                        
                        @foreach($usuario->roles as $role)
                            @php
                                $color = '';
                                switch ($role->name) {
                                    case 'administrador':
                                        $color = 'bg-danger';
                                        break;
                                    case 'abogados':
                                        $color = 'bg-success';
                                        break;
                                    case 'clientes':
                                        $color = 'bg-info';
                                        break;
                                    default:
                                        $color = 'bg-secondary';
                                        break;
                                }
                            @endphp
                            <span class="badge {{ $color }} text-ligth">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <!-- Ejemplos de acciones -->
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-success btn-sm me-2">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="post" id="miFormulario{{ $usuario->id }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="preguntar{{ $usuario->id }}(event)" class="btn btn-danger btn-sm">Eliminar <i class="bi bi-trash"></i></button>
                        </form>
                        <script>
                            function preguntar{{ $usuario->id }}(event) {
                                event.preventDefault();
                                Swal.fire({
                                    title: 'Eliminar registro',
                                    text: '¿Desea eliminar este registro?',
                                    icon: 'question',
                                    showDenyButton: true,
                                    confirmButtonText: 'Eliminar',
                                    confirmButtonColor: '#a5161d',
                                    denyButtonColor: '#270a0a',
                                    denyButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        var form = $('#miFormulario{{ $usuario->id }}');
                                        form.submit();
                                    }
                                });
                            }
                        </script>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<!-- Incluye los estilos y scripts de DataTables desde CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>

<!-- Configuración de DataTables con idioma español -->
<script>
$(document).ready(function() {
    $('#usuarios-table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
        ],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        }
    });
});
</script>

@endsection
