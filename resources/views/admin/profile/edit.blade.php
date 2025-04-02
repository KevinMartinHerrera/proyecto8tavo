@extends('layouts.admin')

@section('title')
    <title>RMJuridico | Editar Perfil</title>
@endsection

@section('ruta')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">Perfil de Usuario</a></li>
    <li class="breadcrumb-item active">Editar Perfil</li>
@endsection

@section('seccion')
    <h1 class="m-0">Editar Perfil</h1>
@endsection

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Editar Perfil</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Dirección</label>
                                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->profile->address ?? '') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Biografía</label>
                                <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($user->profile && $user->profile->photo)
                                    <img src="{{ asset('storage/' . $user->profile->photo) }}" alt="Foto de perfil" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
