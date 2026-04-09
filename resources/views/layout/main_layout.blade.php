<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSC V2</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos -->
    <link rel="shortcut icon" href="{{asset('img/logo.jpg')}}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="/css/style.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="bg-light container-fluid px-5 d-flex flex-column min-vh-100">
        @include('top_bar')

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="row px-4">

            <!-- SIDEBAR -->
            <aside id="sidebar" class="col-md-3 col-lg-2 p-3 bg-white border border-dark rounded align-self-start overflow-auto d-none d-md-block">
                <x-side-bar />
            </aside>
            
            <!-- CONTEÚDO -->
            <main class="col p-5">
                @yield('content')
            </main>

        </div>

        <!-- FOOTER -->
        <footer class="text-center text-secondary py-3">
            <small >LSC1 &copy; {{ date('Y') }}<i class="fa-brands fa-php"></i></small>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                language: {
                    url: "{{ asset('datatables/i18n/pt-BR.json') }}"
                }
            });
        });
    </script>
</body>
</html>
