@extends('layout.main_layout')
@section('content')

<h2 class="text-center">Dados do médico</h2>

<!-- BOTÃO ABAIXO DO H2 -->
<div class="row mb-3">
    <div class="col text-end">
        <a class="btn btn-primary" href="{{ route('admin.medicos') }}">
            <i class="fa-solid fa-door-closed"></i> Voltar
        </a>
    </div>
</div>

<h3>Médico: {{ $medico->nome }}</h3>

<div class="row align-items-start">

    <div class="col-md-8">
        <ul>
            <li><strong>Nome:</strong> {{ $medico->nome }}</li>
            <li><strong>Idade:</strong> {{ $medico->idade }}</li>
            <li><strong>Genero:</strong> {{ $medico->genero }}</li>
            <li><strong>Telefone:</strong> {{ $medico->telefone }}</li>
            <li><strong>Gmail:</strong> {{ $medico->user->email }}</li>
    </div>

    <div class="col-md-4 text-center">
        <img
            class="rounded-circle img-fluid"
            src="{{ $medico->user->foto
                    ? asset('storage/' . $medico->user->foto)
                    : asset('assets/images/perfil.png') }}"
            alt="Foto de perfil"
            style="max-width: 150px;"
        >
    </div>

</div>

<hr>
<h4 class="mb-3">Pacientes vinculados</h4>

<div class="row">
    @forelse ($medico->pacientes as $paciente)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm text-center rounded-4 p-3">

                <img
                    src="{{ $paciente->user->foto
                            ? asset('storage/' . $paciente->user->foto)
                            : asset('assets/images/perfil.png') }}"
                    class="rounded-circle mx-auto mb-3"
                    style="width: 100px; height: 100px; object-fit: cover;"
                    alt="Foto do paciente"
                >

                <h6 class="fw-bold mb-1">
                    {{ $paciente->nome }}
                </h6>

                <small class="text-muted">
                    {{ $paciente->user->email }}
                </small>

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">
                Nenhum paciente vinculado a este médico.
            </div>
        </div>
    @endforelse
</div>

@endsection