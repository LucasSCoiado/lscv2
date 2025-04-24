<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSC V2</title>
    <!--Estilo CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Estilo -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="{{ asset('img/logo.jpg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="row mb-3 align-items-center">
                <div class="col">
                    <a class="logo" href="{{ route('home') }}">
                        <img  src="img/logo.png" alt="Notes logo">
                    </a>
                </div>
                <div class="col text-center">
                    A evolução de meu <span class="text-warning">TCC</span> criado em 2024 LSC1-V2!
                </div>
                <div class="col">
                    <div class="d-flex justify-content-end align-items-center">
                        <span class="me-3"><i class="fa-solid fa-user-circle fa-lg text-secondary me-3"></i>[email]</span>
                        <a href="{{ route('logout') }}" class="btn btn-outline-secondary px-3">
                            Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr>
            
            @yield('content')
        </div>
    </div>
</body>
</html>