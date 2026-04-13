<div class="d-flex flex-column sidebar pt-4">
    <a href="{{ route('home') }}" class="btn btn-secondary btn-outline-dark text-light me-2"><i class="fas fa-home"></i> Menu</a>

    <hr>
    @if(auth()->user()->role ==='paciente')
        <a href="{{ route('paciente.crises') }}" class="btn btn-secondary btn-outline-dark text-light me-2"><i class="fa-solid fa-table"></i> Crises</a>
        <hr>
    @endif
    @if(auth()->user()->role === 'medico' || auth()->user()->role === 'admin')
        <a href="{{ route('admin.pacientes') }}" class="btn btn-secondary btn-outline-dark text-light me-2"><i class="fa-solid fa-bed-pulse"></i> Meus pacientes</a>
        <hr>
    @endif
    @if(auth()->user()->role ==='admin')
        <a href="{{ route('allPacientes') }}" class="btn btn-secondary btn-outline-dark text-light me-2"><i class="fa-solid fa-bed-pulse"></i> Pacientes</a>
        <hr>
    @endif
    @if(auth()->user()->role ==='admin')
        <a href="{{ route('admin.medicos') }}" class="btn btn-secondary btn-outline-dark text-light me-2"><i class="fa-solid fa-user-doctor"></i> Médicos</a>
        <hr>
    @endif
    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-outline-dark text-light me-2"><i class="fa-solid fa-user"></i> Usuário</a>
    <hr>
    <div class="text-center mt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                Logout
            </button>
        </form>
    </div>    
    
</div>