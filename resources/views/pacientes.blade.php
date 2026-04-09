@extends('layout.main_layout')
@section('content')

    <div class="container">
        <h3>Pacientes</h3>
        <hr>
        <div class="row">
            @foreach ($pacientes as $paciente)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $paciente->nome ?? 'Sem nome' }}</h5>
                            <p class="card-text">
                                <strong>Idade:</strong> {{ $paciente->idade ?? 'N/A' }}<br>
                                <strong>Telefone:</strong> {{ $paciente->telefone ?? 'N/A' }}<br>
                                <strong>Gênero:</strong> {{ $paciente->genero ?? 'N/A' }}<br>
                                <strong>Médico:</strong> 
                                @if ($paciente->medicos->isNotEmpty())
                                    {{ $paciente->medicos->pluck('nome')->join(', ') }}
                                @else
                                    Sem médico
                                @endif
                            </p>
                            <a href="{{ route('dados.paciente', ['id' => $paciente->id]) }}" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection