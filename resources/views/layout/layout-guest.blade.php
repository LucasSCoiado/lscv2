<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSC V2</title>
    <!--Estilo CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Estilo -->
    <link rel="shortcut icon" href="{{asset('img/logo.jpg')}}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="bg-light container-fluid px-5 d-flex flex-column min-vh-100">
        <!-- TOP BAR FULL WIDTH -->
        <header class="w-100 px-3">
            @include('layout.top-bar')
        </header>

        <!-- CONTEÚDO -->
        <main class="flex-fill container">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="text-center text-secondary py-3">
            <small>LSC1 &copy; {{ date('Y') }}<i class="fa-brands fa-php"></i></small>
        </footer>
    </div>
</body>
</html>