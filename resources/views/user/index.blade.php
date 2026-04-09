@extends('layout.main_layout')
@section('content')

    <div class="w-100 p-4">
        <div class="row mt-4">
            @if($isMedico)
                <h3>Médico</h3>
            @elseif($isAdmin)
                <h3>Administrador</h3>
            @elseif($isPaciente)
                <h3>Paciente</h3>
            @endif
        </div>
        @if (session('success'))
            <div class="alert alert-success mt-3">
                Sucesso! {{ session('success') }}
            </div>
        @endif
        <div class="row align-items-start">

            <!-- COLUNA FOTO -->
            <div class="col-12 col-md-4 mb-4">
                <div class="border border-dark rounded bg-white text-center p-3">
                    <img class="rounded-circle img-fluid mb-2"
                        src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/images/perfil.png') }}"
                        alt="Foto de perfil" style="width: 180px; height: 180px; object-fit: cover;"
                    >
                    <h3 class="mt-2">{{ $user->nome }}</h3>
                </div>
            </div>

            <!-- COLUNA PERFIL -->
            <div class="col-12 col-md-8">
                <div class="d-flex gap-5">
                    <div>
                        @if($isMedico && $user->medico)
                            <i class="fa-solid fa-user me-3"></i>
                            <p class="fw-bold">{{ $user->medico->nome }}</p>
                        @elseif($isAdmin && $user->admin)
                            <i class="fa-solid fa-user me-3"></i>
                            <p class="fw-bold">{{ $user->admin->nome }}</p>
                        @elseif($isPaciente && $user->paciente)
                            <i class="fa-solid fa-user me-3"></i>
                            <p class="fw-bold">{{ $user->paciente->nome }}</p>
                        @endif
                    </div>

                    <div>
                        <i class="fa-solid fa-at me-3"></i>
                        <p class="fw-bold">{{ $user->email }}</p>
                    </div>

                    <div>
                        <i class="fa-regular fa-address-book"></i>
                        <p class="fw-bold">{{ $user->role }}</p>
                    </div>

                    <div>
                        @if ($isAdmin)
                            <i class="fa-solid fa-phone"></i>
                            <p class="fw-bold">{{ $user->admin->telefone }}</p>
                        @endif
                    </div>

                </div>
                <hr>
                <div class="d-flex ">
                    @if ($isAdmin)
                        <h3>Contratado em: {{ $user->created_at->format('d/m/Y') }}</h3>
                    @endif
                    
                    <div class="card bg-white p-4 m-2">
                        @can('paciente')
                            <p><span class="fw-bold">Nome:</span> {{ $user->paciente->nome }}</p>
                            <p><span class="fw-bold">Idade:</span> {{ $user->paciente->idade }}</p>
                            <p><span class="fw-bold">Telefone:</span> {{ $user->paciente->telefone }}</p>
                            <p><span class="fw-bold">Sexo:</span> {{ $user->paciente->genero }}</p>
                        @endcan
                        @can('medico')
                            <p><span class="fw-bold">Nome:</span> {{ $user->medico->nome }}</p>
                            <p><span class="fw-bold">CRM:</span> {{ $user->medico->crm }}</p>
                            <p><span class="fw-bold">Especialidade:</span> {{ $user->medico->especialidade }}</p>
                            <p><span class="fw-bold">Telefone:</span> {{ $user->medico->telefone }}</p>
                        @endcan
                        <p><span class="fw-bold">Email:</span> {{ $user->email }}</p>
                        <div class="text-start m-2">
                            <a href="{{ route('user.alter-senha', ['id' => $user->id]) }}" class="btn btn-primary px-2">
                                Alterar senha
                            </a>
                            <a href="{{ route('user.edit-user', ['id' => $user->id]) }}" class="btn btn-primary px-2">
                                Alterar dados
                            </a>
                        </div>
                    </div>
                    @can('medico')
                        <div class="card bg-white p-4 m-2">
                            <h3>Pacientes</h3>
                            @foreach ($meusPacientes as $mp)
                                <p>{{ $mp->nome }}</p>
                            @endforeach
                        </div>
                    @endcan
                    @can('paciente')
                        <div class="card bg-white p-4 m-2">
                            <h3>Crises no mês</h3>
                            <h5 class="text-center">{{ $crisesMes }}</h5>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
        <hr>

    </div>

@endsection