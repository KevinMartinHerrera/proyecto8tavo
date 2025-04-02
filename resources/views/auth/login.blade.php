<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset("css/login.css") }}">

    <title>SISTEMA DE PREUBA | Login</title>
</head>

<body>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <img src="{{ asset('img/login/ejemplo.jpg') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents d-flex align-items-center justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3 class=>Bienvenido a <strong>SISTEMA DE PRUEBAS </strong></h3>
                        </div>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group first">
                                <label for="username" class="text-secondary"></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="username" placeholder="Ingresa tu correo electrónico" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group last mb-4">
                                <label for="password" class="text-secondary"></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Ingresa tu contraseña" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
