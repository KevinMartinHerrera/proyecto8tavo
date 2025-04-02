@extends('layouts.admin')

@section('title')
    <title>RMJuridico | Perfil de Usuario</title>
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Perfil de Usuario</li>
@endsection

@section('seccion')
    <h1 class="m-0">Perfil de Usuario</h1>
@endsection

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Perfil de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <p class="form-control">{{ $user->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <p class="form-control">{{ $user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <p class="form-control">{{ $user->profile->phone ?? 'No proporcionado' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <p class="form-control">{{ $user->profile->address ?? 'No proporcionado' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Biografía</label>
                            <p class="form-control">{{ $user->profile->bio ?? 'No proporcionado' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            @if($user->profile && $user->profile->photo)
                                <img src="{{ asset('storage/' . $user->profile->photo) }}" alt="Foto de perfil" class="img-thumbnail" width="150">
                            @else
                                <p>No proporcionado</p>
                            @endif
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
