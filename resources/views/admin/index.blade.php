@extends('layouts.admin')

@section('title')
<title>RMJuridico | Administrador</title>
@endsection

@section('ruta')
  <li class="breadcrumb-item"><a href={{ route('admin.index') }}>Home</a></li>
  <li class="breadcrumb-item active">Panel De Control Administrador</li> 
@endsection

@section('seccion')
  <h1 class="m-0">Panel De Control</h1>
@endsection

@section('container')
<div class="container-fluid">
  <div class="row">
      <!-- Sección de Gestión de Casos -->
      <div class="col-lg-6 col-xl-4 mb-4">
          <div class="card bg-info text-white h-100">
              <div class="card-header">
                  <h5 class="m-0"><i class="fas fa-briefcase"></i> Gestión de Casos</h5>
              </div>
              <div class="card-body">
                  <h6 class="card-title">Administrar todos los Casos</h6>
                  <p class="card-text">Crea, visualiza y gestiona los Casos.</p>
                  <a href="{{route('casos.index')}}" class="btn btn-light text-info">Ir a Gestión de Casos</a>
              </div>
          </div>
      </div>

      <!-- Sección de Gestión de Archivos -->
      <div class="col-lg-6 col-xl-4 mb-4">
          <div class="card bg-primary text-white h-100">
              <div class="card-header">
                  <h5 class="m-0"><i class="fas fa-folder-open"></i> Gestión de Archivos</h5>
              </div>
              <div class="card-body">
                  <h6 class="card-title">Administrar todos los Archivos</h6>
                  <p class="card-text">Crea, visualiza y gestiona los Archivos.</p>
                  <a href="{{route('carpetas.index')}}" class="btn btn-light text-primary">Ir a Gestión de Archivos</a>
              </div>
          </div>
      </div>

      <!-- Sección de Gestión de Tareas -->
      <div class="col-lg-6 col-xl-4 mb-4">
          <div class="card bg-success text-white h-100">
              <div class="card-header">
                  <h5 class="m-0"><i class="fas fa-tasks"></i> Gestión de Tareas</h5>
              </div>
              <div class="card-body">
                  <h6 class="card-title">Organiza y asigna tareas</h6>
                  <p class="card-text">Asigna y visualiza tareas para tu equipo.</p>
                  <a href="{{ route('boards.index') }}" class="btn btn-light text-success">Ir a Gestión de Tareas</a>
              </div>
          </div>
      </div>

      <!-- Sección de Gestión de Usuarios -->
      <div class="col-lg-6 col-xl-4 mb-4">
            <div class="card bg-secondary text-white h-100">
                <div class="card-header">
                    <h5 class="m-0"><i class="fas fa-user-cog"></i> Gestión de Usuarios</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">Administrar a los usuarios</h6>
                    <p class="card-text">Añade y gestiona la información de usuarios.</p>
                    <a href="{{ route('usuario.index') }}" class="btn btn-light text-secondary">Ir a Gestión de Usuarios</a>
                </div>
            </div>
        </div>
      <!-- Sección de Gestión de Clientes -->
      <div class="col-lg-6 col-xl-4 mb-4">
          <div class="card bg-warning text-white h-100">
              <div class="card-header">
                  <h5 class="m-0"><i class="fas fa-user-tie"></i> Gestión de Clientes</h5>
              </div>
              <div class="card-body">
                  <h6 class="card-title">Administrar a los clientes</h6>
                  <p class="card-text">Añade y gestiona la información de los clientes.</p>
                  <a href="#" class="btn btn-light text-warning">Ir a Gestión de Clientes</a>
              </div>
          </div>
      </div>



      <!-- Sección de Configuración del Sistema -->
      <div class="col-lg-6 col-xl-4 mb-4">
          <div class="card bg-danger text-white h-100">
              <div class="card-header">
                  <h5 class="m-0"><i class="fas fa-cogs"></i> Configuración del Sistema</h5>
              </div>
              <div class="card-body">
                  <h6 class="card-title">Personaliza tu sistema</h6>
                  <p class="card-text">Configura las preferencias del sistema para adaptarlo a tus necesidades.</p>
                  <a href="#" class="btn btn-light text-danger">Configurar Sistema</a>
              </div>
          </div>
      </div>
  </div>
  <!-- /.row -->
</div>

<style>
  .card {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      border-radius: 10px; 
  }
  .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }
  .btn-light {
      transition: background-color 0.2s, color 0.2s;
  }
  .btn-light:hover {
      background-color: #f8f9fa;
      color: #343a40;
  }
  .card-header {
      border-radius: 10px 10px 0 0; /* Bordes redondeados para el header */
  }
  .card-body {
      display: flex;
      flex-direction: column;
      justify-content: space-between; /* Asegurar que el contenido esté distribuido uniformemente */
  }
</style>
@endsection

