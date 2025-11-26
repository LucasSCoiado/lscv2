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
<body class="container-pai">
    <div class="container">
        <div class="row justify-content-center">  
            
            @include('layout.side-bar-guest')
            
            @yield('content')

            <footer class="text-center text-secondary mt-3">
                <small>LSC1&copy;<?=date('Y') ?> </small>
            </footer>
        </div>
    </div>
</body>
</html>