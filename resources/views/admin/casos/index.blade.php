@extends('layouts.admin')

@section('title')
    <title>RMJuridico | Casos</title>
    <!-- Incluye jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Administrador de Casos</li>
@endsection

@section('seccion')
    <h1 class="m-0">Administrador de Casos</h1>
@endsection

@section('container')
<div class="container">
    <!-- Barra de herramientas con el botón para agregar un nuevo caso -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('casos.create') }}" class="btn btn-success">
            <i class="fas fa-folder-plus"></i> Crear Nuevo Caso
        </a>
    </div>

    <div class="table-responsive">
        <table id="casos-table" class="table table-hover table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Número de Caso</th>
                    <th>Fecha de Apertura</th>
                    <th>Descripción</th>
                    <th>Tipo de Caso</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($casos as $caso)
                <tr>
                    <td>{{ $caso->numero_caso }}</td>
                    <td>{{ $caso->fecha_apertura }}</td>
                    <td>{{ $caso->descripcion }}</td>
                    <td>{{ $caso->tipo_caso }}</td>
                    <td>{{ $caso->estado }}</td>
                    <td>
                        <!-- Ejemplo de acciones -->
                        <a href="{{ route('carpetas.show', $caso->carpeta->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-folder-open"></i> {{-- Ver Carpeta --}}
                        </a>
                        <a href="#" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalCaso{{ $caso->id }}">
                            <i class="fas fa-eye"></i>{{--  Ver --}}
                        </a>
                        <a href="{{ route('casos.edit', $caso->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> {{-- Editar --}}
                        </a>
                        <form id="miFormulario{{ $caso->id }}" action="{{ route('casos.destroy', $caso->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="preguntar{{ $caso->id }}(event)">
                                <i class="fas fa-trash-alt"></i> {{-- Eliminar --}}
                            </button>
                        </form>
                        <script>
                            function preguntar{{ $caso->id }}(event) {
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
                                        var form = document.getElementById('miFormulario{{ $caso->id }}');
                                        form.submit();
                                    }
                                });
                            }
                        </script>
                        <!-- Modal -->
                        <div class="modal fade" id="modalCaso{{ $caso->id }}" tabindex="-1" aria-labelledby="modalCasoLabel{{ $caso->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCasoLabel{{ $caso->id }}">Detalles del Caso</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="numeroCaso{{ $caso->id }}" class="form-label">Número de Caso:</label>
                                                <input type="text" readonly class="form-control" id="numeroCaso{{ $caso->id }}" value="{{ $caso->numero_caso }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="fechaApertura{{ $caso->id }}" class="form-label">Fecha de Apertura:</label>
                                                <input type="text" readonly class="form-control" id="fechaApertura{{ $caso->id }}" value="{{ $caso->fecha_apertura }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="descripcion{{ $caso->id }}" class="form-label">Descripción:</label>
                                                <textarea readonly class="form-control" id="descripcion{{ $caso->id }}" rows="3">{{ $caso->descripcion }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tipoCaso{{ $caso->id }}" class="form-label">Tipo de Caso:</label>
                                                <input type="text" readonly class="form-control" id="tipoCaso{{ $caso->id }}" value="{{ $caso->tipo_caso }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="estado{{ $caso->id }}" class="form-label">Estado:</label>
                                                <input type="text" readonly class="form-control" id="estado{{ $caso->id }}" value="{{ $caso->estado }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="fechaCierre{{ $caso->id }}" class="form-label">Fecha de Cierre:</label>
                                                <input type="text" readonly class="form-control" id="fechaCierre{{ $caso->id }}" value="{{ $caso->fecha_cierre }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="numeroExpediente{{ $caso->id }}" class="form-label">Número de Expediente:</label>
                                                <input type="text" readonly class="form-control" id="numeroExpediente{{ $caso->id }}" value="{{ $caso->numero_expediente }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="abogado{{ $caso->id }}" class="form-label">Abogado:</label>
                                                <input type="text" readonly class="form-control" id="abogado{{ $caso->id }}" value="{{ $caso->abogado->name }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="cliente{{ $caso->id }}" class="form-label">Cliente:</label>
                                                <input type="text" readonly class="form-control" id="cliente{{ $caso->id }}" value="{{ $caso->cliente->name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary" onclick="generarPDF('{{ $caso->id }}')">
                                            <i class="fas fa-print"></i> Imprimir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> 
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


<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Configuración de DataTables con idioma español -->
<script>
$(document).ready(function() {
    $('#casos-table').DataTable({
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

{{-- scrip para el pdf --}}
<script>
     function generarPDF(casoId) {
        // Obtener los detalles del caso desde el modal
        var modal = document.getElementById('modalCaso' + casoId);
        var numeroCaso = modal.querySelector('#numeroCaso' + casoId).value;
        var fechaApertura = modal.querySelector('#fechaApertura' + casoId).value;
        var descripcion = modal.querySelector('#descripcion' + casoId).value;
        var tipoCaso = modal.querySelector('#tipoCaso' + casoId).value;
        var estado = modal.querySelector('#estado' + casoId).value;
        var fechaCierre = modal.querySelector('#fechaCierre' + casoId).value;
        var numeroExpediente = modal.querySelector('#numeroExpediente' + casoId).value;
        var abogado = modal.querySelector('#abogado' + casoId).value;
        var cliente = modal.querySelector('#cliente' + casoId).value;

        // Crear un nuevo PDF
        const { jsPDF } = window.jspdf;
        var doc = new jsPDF();

        // Estilos para el PDF
        var headerColor = "#2D8FDD";
        var bodyColor = "#FFFFFF";
        var textColor = "#000000";
        var fontSize = 12;
        var marginLeft = 20;
        var marginTop = 20;
        var columnWidth = 100;

        // Encabezado
        doc.setFontSize(18);
        doc.setTextColor(headerColor);
        doc.text("Detalles del Caso", marginLeft, marginTop);

        // Contenido del caso
        doc.setFontSize(fontSize);
        doc.setTextColor(textColor);
        doc.setFillColor(bodyColor);

        var yPos = marginTop + 20;

        doc.text(`Número de Caso: ${numeroCaso}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Fecha de Apertura: ${fechaApertura}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Descripción: ${descripcion}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Tipo de Caso: ${tipoCaso}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Estado: ${estado}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Fecha de Cierre: ${fechaCierre}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Número de Expediente: ${numeroExpediente}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Abogado: ${abogado}`, marginLeft, yPos);
        yPos += 10;
        doc.text(`Cliente: ${cliente}`, marginLeft, yPos);

        // Guardar el PDF con un nombre específico
        doc.save('Detalles_Caso_' + casoId + '.pdf');
    }
</script>

@endsection
