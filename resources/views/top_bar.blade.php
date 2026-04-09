<div class="row mb-0 align-items-center">
    <div class="col-auto d-lg-none">
        <button class="btn btn-outline-secondary" id="btnSidebar">
            <i class="fas fa-bars">
            </i>
        </button>
    </div>
    <!-- LOGO -->
    <div class="col-auto">
        <a class="logo" href="{{ route('home') }}">
            <img class="img-fluid" style="max-width:120px" src="{{ asset('img/logo.png') }}" alt="Notes logo">
        </a>
    </div>

    <!-- TEXTO (desktop) -->
    <div class="col d-none d-lg-flex justify-content-center text-center">
        A evolução de meu <span class="text-warning">TCC</span> criado em 2024 LSC1-V2!
    </div>

    <!-- LOGOUT ÍCONE (sidebar/mobile) -->

    <div class="col-auto d-flex d-lg-none ms-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- USUÁRIO + LOGOUT (desktop) -->
    <div class="col-auto d-none d-lg-flex">
        <div class="d-flex align-items-center">
            <span class="me-3">
                <img class="rounded-circle img-fluid mb-2"
                    src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('assets/images/perfil.png') }}"
                    alt="Foto de perfil" style="width: 50px; height: 50px; object-fit: cover;">
                {{ Auth::user()->email }}
            </span>
        </div>
    </div>

    <hr>
</div>