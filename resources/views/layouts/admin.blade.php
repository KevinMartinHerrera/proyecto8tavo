<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @yield('title')


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href={{asset('plugins/fontawesome-free/css/all.min.css')}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{ asset('dist/css/adminlte.min.css') }}>
  <!-- Custom style -->
  {{-- sweetalert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="
    https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js
    "></script>




</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                        @if(Auth::user()->profile && Auth::user()->profile->photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="Foto de perfil" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle fa-lg"></i> <!-- Icono de usuario por defecto si no hay foto -->
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            {{ __('Perfil') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
        @endguest
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('img/login/ejemplo.jpg') }}" alt="Sistema De Prueba" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema De Prueba</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard Menu -->
            <li class="nav-item">
                <a href={{ route('admin.index') }} class="nav-link {{ request()->is('/admin') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <!-- Gestión de Casos -->
            <li class="nav-item">
                <a href="{{route('carpetas.index')}}" class="nav-link {{ request()->is('gestion-de-archivos*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-folder"></i>
                    <p>
                        Gestión de Archivos
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Todos los Casos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Crear Nuevo Caso</p>
                        </a>
                    </li>
                </ul> --}}
            </li>

            <!-- Gestión de Tareas -->
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is('gestion-tareas*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        Gestión de Tareas
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ver Tareas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Asignar Tareas</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Gestión de Abogados -->
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is('gestion-abogados*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Gestión de Abogados
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ver Abogados</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Agregar Abogado</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Gestión de Clientes -->
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is('gestion-clientes*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>
                        Gestión de Clientes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ver Clientes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Agregar Cliente</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Gestión de Usuarios -->
            <li class="nav-item">
                <a href="{{ route('usuario.index') }}" class="nav-link {{ request()->is('gestion-usuarios*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>
                        Gestión de Usuarios
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('usuario.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ver Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('usuario.create')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Agregar Usuario</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Configuración del Sistema -->
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->is('configuracion-sistema*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Configuración del Sistema
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Preferencias</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            @yield('seccion')
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @yield('ruta')
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
    @if(Session::has('mensaje') && Session::has('icono'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Mensaje",
                    text: "{{ Session::get('mensaje') }}",
                    icon: "{{ Session::get('icono') }}",
                    timer: 3000, // Tiempo en milisegundos, 3000ms = 3 segundos
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
    <!-- Main content -->
    <div class="content">
        @yield('container')
      <!-- /.container-fluid -->
    </div>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023-2024 <a href="">sistema de pruebas </a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src={{asset('plugins/jquery/jquery.min.js')}}></script>
<!-- Bootstrap 4 -->
<script src={{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}></script>
<!-- AdminLTE App -->
<script src={{asset('dist/js/adminlte.min.js')}}></script>
@yield('scripts')

@yield('styles')
</body>
</html>
